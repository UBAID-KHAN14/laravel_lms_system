<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Teacher\Course\Course;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use App\Models\Teacher\Course\CourseSection;
use App\Models\Teacher\Course\CourseLecture;
use App\Models\Teacher\Course\LectureMaterial;
use App\Models\Teacher\Course\FAQ;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $courses = Course::with(['category', 'subCategory', 'pricing'])->where('teacher_id', Auth::id())->latest()->get();
        return view('teacher.course.index', compact('courses'));
    }


    public function create()
    {
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        return view('teacher.course.create', compact('categories', 'sub_categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'level'           => 'required|in:beginner,intermediate,advanced',
            'thumbnail'       => 'required|image|mimes:png,jpg,jpeg,webp|max:10240',
        ]);

        $imageName = null;
        if ($request->hasFile('thumbnail')) {
            $imageName = $request->file('thumbnail')->store('courses', 'public');
        }

        $course = new Course();
        $course->teacher_id = Auth::id();
        $course->category_id = $request->category_id;
        $course->sub_category_id = $request->sub_category_id;
        $course->title = trim($request->title);
        $course->slug = Str::slug($request->title);
        $course->description = trim($request->description);
        $course->level = $request->level;
        $course->status = 'draft';
        $course->thumbnail = $imageName;
        $course->save();

        return redirect()->route('teacher.courses.manage', $course->id)->with('success', 'Course created successfully.');
    }


    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        $this->authorize('update', $course);
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        return view('teacher.course.manage.basic', compact('course', 'categories', 'sub_categories'));
    }


    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        // Authorization
        $this->authorize('update', $course);

        $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'level'           => 'required|in:beginner,intermediate,advanced',
            'thumbnail'       => 'nullable|image|mimes:png,jpg,jpeg,webp|max:10240',
        ]);


        if ($request->hasFile('thumbnail')) {

            if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $course->thumbnail = $request->file('thumbnail')->store('courses', 'public');
        }

        $course->category_id     = $request->category_id;
        $course->sub_category_id = $request->sub_category_id;
        $course->title           = trim($request->title);
        $course->slug            = Str::slug($request->title);
        $course->description     = trim($request->description);
        $course->level           = $request->level;
        $course->status          = 'draft';

        $course->save();

        return redirect()->route('teacher.courses.index')->with('success', 'Course updated successfully and sent for review.');
    }



    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);

        $this->authorize('delete', $course);

        // Prevent deleting if students are enrolled
        if ($course->enrollments()->count() > 0) {
            return back()->with('error', 'Cannot delete course with enrolled students.');
        }

        // Delete thumbnail
        if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        // Delete lectures and their files
        foreach ($course->lectures as $lecture) {

            // Delete video
            if ($lecture->video_file && Storage::disk('public')->exists($lecture->video_file)) {
                Storage::disk('public')->delete($lecture->video_file);
            }

            // Delete materials
            foreach ($lecture->materials as $material) {
                if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
                    Storage::disk('public')->delete($material->file_path);
                }

                $material->delete();
            }

            $lecture->delete();
        }

        // Delete sections
        foreach ($course->sections as $section) {
            $section->delete();
        }

        // Delete FAQs
        foreach ($course->faqs as $faq) {
            $faq->delete();
        }

        // Delete pricing (single relation)
        if ($course->pricing) {
            $course->pricing->delete();
        }

        // Finally delete the course
        $course->delete();

        return redirect()
            ->back()
            ->with('success', 'Course deleted successfully.');
    }

    // START DELETE BULK
    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true);

        if (!is_array($ids) || empty($ids)) {
            return back()->with('error', 'Invalid selection');
        }

        DB::beginTransaction();

        try {

            $courses = Course::whereIn('id', $ids)
                ->where('teacher_id', Auth::id())
                ->with(['sections', 'lectures.materials'])
                ->get();

            foreach ($courses as $course) {

                // Policy check (optional)
                $this->authorize('delete', $course);

                // Delete thumbnail
                if (
                    $course->thumbnail &&
                    Storage::disk('public')->exists($course->thumbnail)
                ) {

                    Storage::disk('public')->delete($course->thumbnail);
                }

                // Delete lectures + files
                foreach ($course->lectures as $lecture) {

                    // Video
                    if (
                        $lecture->video_file &&
                        Storage::disk('public')->exists($lecture->video_file)
                    ) {

                        Storage::disk('public')->delete($lecture->video_file);
                    }

                    // Materials
                    foreach ($lecture->materials as $material) {

                        if (Storage::disk('public')->exists($material->file_path)) {
                            Storage::disk('public')->delete($material->file_path);
                        }

                        $material->delete();
                    }

                    $lecture->delete();
                }

                // Delete sections
                foreach ($course->sections as $section) {
                    $section->delete();
                }

                // Delete course
                $course->delete();
            }

            DB::commit();

            return back()->with('success', 'Selected courses deleted successfully!');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Delete failed. Try again.');
        }
    }






    // FOR THE APPROVAL
    public function submit(string $id)
    {
        $course = Course::findOrFail($id);
        $this->authorize('update', $course);
        if (!$course->canBeSubmitted()) {
            return back()->with('error', 'Complete the course first.');
        }
        $course->status = 'pending';
        $course->save();
        return back()->with('success', 'Course submitted for review.');
    }





    public function manage_course($id, Request $request)
    {
        $course = Course::where('id', $id)
            ->where('teacher_id', Auth::id())
            ->firstOrFail();

        $categories = Category::all();
        $sub_categories = SubCategory::all();

        $tab = $request->get('tab', 'basic');

        // Load sections with lectures
        $sections = $course->sections()->with('lectures')->get();

        // Load FAQs
        $faqs = $course->faqs()->get();
        $currencies = Currency::where('is_active', true)->get();

        return view('teacher.course.manage.index', compact('course', 'tab', 'sections', 'faqs', 'categories', 'sub_categories', 'currencies'));
    }

    // update basic course
    public function updateBasic(Request $request, $id)
    {
        $course = Course::where('id', $id)
            ->where('teacher_id', Auth::id())
            ->firstOrFail();

        $this->authorize('update', $course);

        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'sub_category_id'    => 'required|exists:sub_categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'level'       => 'required|string',
            'thumbnail'   => 'nullable|image|mimes:png,jpg,jpeg,webp|max:10240',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $course->thumbnail = $request->file('thumbnail')->store('courses', 'public');
        }

        $course->category_id = $request->category_id;
        $course->sub_category_id = $request->sub_category_id;
        $course->title = trim($request->title);
        $course->slug  = Str::slug($request->title);
        $course->description = trim($request->description);
        $course->level = trim($request->level);
        $course->save();

        return back()->with('success', 'Basic information updated.');
    }


    public function preview(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            return abort(403);
        }

        $course->load([
            'sections.lectures.materials',
            'faqs',
            'pricing'
        ]);

        return view('teacher.course.preivew.preview', compact('course'));
    }
}
