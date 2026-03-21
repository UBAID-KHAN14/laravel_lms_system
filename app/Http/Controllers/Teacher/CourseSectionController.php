<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher\Course\Course;
use App\Models\Teacher\Course\CourseLecture;
use App\Models\Teacher\Course\CourseSection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseSectionController extends Controller
{
    use AuthorizesRequests;

    // public function index()
    // {
    //     $sections = CourseSection::whereHas('course', function ($query) {
    //         $query->where('teacher_id', Auth::id());
    //     })->with('course')->orderBy('course_id')->orderBy('order_number')->get();

    //     return view('teacher.sections.index', compact('sections'));
    // }



    // public function create()
    // {
    //     $courses = Course::where('teacher_id', Auth::id())->get();
    //     return view('teacher.sections.create', compact('courses'));
    // }



    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'sections.*.course_id' => 'required|exists:courses,id',
    //         'sections.*.title' => 'required|string|max:255',
    //         'sections.*.order_number' => 'required|integer',
    //     ]);
    //     foreach ($request->sections as $sectionData) {
    //         $course = Course::where('id', $sectionData['course_id'])->where('teacher_id', Auth::id())
    //             ->firstOrFail();
    //         $section = new CourseSection();
    //         $section->course_id = $course->id;
    //         $section->title = $sectionData['title'];
    //         $section->order_number = $sectionData['order_number'];
    //         $section->save();
    //     }
    //     return redirect()->route('teacher.course_sections.index')
    //         ->with('success', 'Course sections created successfully.');
    // }


    // public function edit(string $id)
    // {
    //     $courseSection = CourseSection::findOrFail($id);
    //     $this->authorize('update', $courseSection);
    //     $courses = Course::where('teacher_id', Auth::id())->get();
    //     return view('teacher.sections.edit', compact('courseSection', 'courses'));
    // }


    // public function update(Request $request, string $id)
    // {
    //     $request->validate([
    //         'course_id' => 'required|exists:courses,id',
    //         'title' => 'required|string|max:255',
    //         'order_number' => 'required|integer',
    //     ]);

    //     $courseSection = CourseSection::findOrFail($id);

    //     $this->authorize('update', $courseSection);

    //     $course = Course::where('id', $request->course_id)->where('teacher_id', Auth::id())
    //         ->firstOrFail();
    //     $courseSection->course_id = $course->id;
    //     $courseSection->title = $request->title;
    //     $courseSection->order_number = $request->order_number;
    //     $courseSection->save();

    //     return redirect()->route('teacher.course_sections.index')
    //         ->with('success', 'Course section updated successfully.');
    // }


    // public function destroy(string $id)
    // {
    //     $courseSection = CourseSection::findOrFail($id);
    //     $this->authorize('delete', $courseSection);
    //     $courseSection->delete();

    //     return redirect()->route('teacher.course_sections.index')
    //         ->with('success', 'Course section deleted successfully.');
    // }


    // public function store(Request $request, Course $course)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //     ]);

    //     $section = $course->sections()->create([
    //         'title' => $request->title,
    //     ]);

    //     // Return JSON if AJAX request
    //     if ($request->wantsJson()) {
    //         return response()->json([
    //             'success' => true,
    //             'section' => $section,
    //             'message' => 'Section added successfully'
    //         ]);
    //     }

    //     return back()->with('success', 'Section added successfully');
    // }

    public function saveCurriculum(Request $request, Course $course)
    {
        // ================= VALIDATION =================
        $request->validate([
            'sections' => 'required|array|min:1',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.lectures' => 'nullable|array',
            'sections.*.lectures.*.title' => 'required|string|max:255',
            'sections.*.lectures.*.video_url' => 'nullable|url',
            'sections.*.lectures.*.video_file' => 'nullable|mimes:mp4,mov,avi,webm,mkv|max:512000',
            'sections.*.lectures.*.is_preview' => 'nullable|in:1,0',

        ]);

        $requestSectionIds = [];
        $order = 1;

        // ================= SECTIONS LOOP =================
        foreach ($request->sections as $sectionData) {
            if (!empty($sectionData['id'])) {
                $section = CourseSection::findOrFail($sectionData['id']);
            } else {
                $section = new CourseSection();
                $section->course_id = $course->id;
            }
            $section->title = $sectionData['title'];
            $section->order_number = $order;
            $section->save();

            $requestSectionIds[] = $section->id;

            // ================= LECTURES =================
            $requestLectureIds = [];

            if (!empty($sectionData['lectures'])) {
                foreach ($sectionData['lectures'] as $lectureData) {

                    // ---- UPDATE OR CREATE LECTURE ----
                    if (!empty($lectureData['id'])) {
                        $lecture = CourseLecture::findOrFail($lectureData['id']);
                    } else {
                        $lecture = new CourseLecture();
                        $lecture->section_id = $section->id;
                    }

                    $lecture->title = $lectureData['title'];
                    $lecture->description = $lectureData['description'] ?? null;
                    $lecture->video_url = $lectureData['video_url'] ?? null;
                    $lecture->is_preview = (bool) ($lectureData['is_preview'] ?? false);

                    // ---- VIDEO UPLOAD (ONLY IF NEW FILE) ----
                    if (isset($lectureData['video_file']) && $lectureData['video_file'] instanceof \Illuminate\Http\UploadedFile) {
                        $path = $lectureData['video_file']->store('lectures/videos', 'public');
                        $lecture->video_file = $path;

                        // ===== Get duration =====
                        $getID3 = new \getID3;
                        $fileInfo = $getID3->analyze(storage_path('app/public/' . $path));

                        if (isset($fileInfo['playtime_seconds'])) {
                            $lecture->duration_seconds = (int) $fileInfo['playtime_seconds'];
                        }
                    }


                    $lecture->save();
                    $requestLectureIds[] = $lecture->id;
                }
            }

            // ---- DELETE REMOVED LECTURES ----
            $section->lectures()->whereNotIn('id', $requestLectureIds)->delete();
            $order++;
        }

        // ================= DELETE REMOVED SECTIONS =================
        $course->sections()->whereNotIn('id', $requestSectionIds)->delete();

        return back()->with('success', 'Curriculum saved or updated successfully!');
    }



    public function destroy(CourseSection $section)
    {
        $this->authorize('delete', $section);

        // Delete all lectures under this section
        foreach ($section->lectures as $lecture) {

            // Delete lecture video
            if ($lecture->video_file && Storage::disk('public')->exists($lecture->video_file)) {
                Storage::disk('public')->delete($lecture->video_file);
            }

            // Delete lecture materials
            foreach ($lecture->materials as $material) {
                if (Storage::disk('public')->exists($material->file_path)) {
                    Storage::disk('public')->delete($material->file_path);
                }
                $material->delete();
            }

            $lecture->delete();
        }

        // Finally delete section
        $section->delete();

        return back()->with('success', 'Curriculum deleted successfully');
    }
}
