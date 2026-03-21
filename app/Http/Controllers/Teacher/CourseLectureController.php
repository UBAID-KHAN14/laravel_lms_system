<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher\Course\CourseLecture;
use App\Models\Teacher\Course\CourseSection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseLectureController extends Controller
{
    // use AuthorizesRequests;

    // public function index()
    // {
    //     $courseLectures = CourseLecture::whereHas('section.course', function ($query) {
    //         $query->where('teacher_id', Auth::id());
    //     })->with('section.course')->orderBy('section_id')->get();
    //     return view('teacher.lectures.index', compact('courseLectures'));
    // }


    // public function create()
    // {
    //     $courseSections = CourseSection::whereHas('course', function ($query) {
    //         $query->where('teacher_id', Auth::id());
    //     })->with('course')->orderBy('course_id')->orderBy('order_number')->get();
    //     return view('teacher.lectures.create', compact('courseSections'));
    // }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'section_id' => 'required|exists:course_sections,id',
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'video_url' => 'nullable|url',
    //         'video_file' => 'nullable|mimes:mp4,mov,avi,webm|max:51200',
    //     ]);

    //     $courseSection = CourseSection::where('id', $request->section_id)
    //         ->whereHas('course', function ($query) {
    //             $query->where('teacher_id', Auth::id());
    //         })->firstOrFail();

    //     $lecture = new CourseLecture();
    //     $lecture->section_id = $courseSection->id;
    //     $lecture->title = $request->title;
    //     $lecture->description = $request->description;
    //     $lecture->video_url = $request->video_url;

    //     if ($request->hasFile('video_file')) {
    //         $path = $request->file('video_file')->store('lectures/videos', 'public');
    //         $lecture->video_file = $path;
    //     }
    //     $lecture->save();
    //     return redirect()->route('teacher.course_lectures.index')
    //         ->with('success', 'Course lecture created successfully.');
    // }



    // public function edit(string $id)
    // {
    //     $courseLecture = CourseLecture::findOrFail($id);
    //     $this->authorize('update', $courseLecture);
    //     $courseSections = CourseSection::whereHas('course', function ($query) {
    //         $query->where('teacher_id', Auth::id());
    //     })->with('course')->orderBy('course_id')->orderBy('order_number')->get();
    //     return view('teacher.lectures.edit', compact('courseLecture', 'courseSections'));
    // }


    // public function update(Request $request, string $id)
    // {
    //     $request->validate([
    //         'section_id' => 'required|exists:course_sections,id',
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'video_url' => 'nullable|url',
    //         'video_file' => 'nullable|mimes:mp4,mov,avi,webm|max:51200',
    //     ]);

    //     $courseLecture = CourseLecture::findOrFail($id);
    //     $this->authorize('update', $courseLecture);
    //     $courseSection = CourseSection::where('id', $request->section_id)->whereHas('course', function ($query) {
    //         $query->where('teacher_id', Auth::id());
    //     })->firstOrFail();
    //     $courseLecture->section_id = $courseSection->id;
    //     $courseLecture->title = $request->title;
    //     $courseLecture->description = $request->description;
    //     $courseLecture->video_url = $request->video_url;

    //     if ($request->hasFile('video_file')) {

    //         if ($courseLecture->video_file) {
    //             Storage::disk('public')->delete($courseLecture->video_file);
    //         }
    //         $path = $request->file('video_file')->store('lectures/videos', 'public');
    //         $courseLecture->video_file = $path;
    //     }
    //     $courseLecture->save();
    //     return redirect()->route('teacher.course_lectures.index')
    //         ->with('success', 'Course lecture updated successfully.');
    // }


    // public function destroy(string $id)
    // {
    //     $courseLecture = CourseLecture::findOrFail($id);
    //     $this->authorize('delete', $courseLecture);

    //     if ($courseLecture->video_file) {
    //         Storage::disk('public')->delete($courseLecture->video_file);
    //     }

    //     $courseLecture->delete();
    //     return redirect()->route('teacher.course_lectures.index')
    //         ->with('success', 'Course lecture deleted successfully.');
    // }

    public function store(Request $request, CourseSection $section)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|mimes:mp4,mov,avi,webm,mkv|max:512000',
        ]);

        $lectureData = [
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => $request->video_url,
        ];

        // $lectureData = new CourseLecture();
        // $lectureData->section_id

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('lectures/videos', 'public');
            $lectureData['video_file'] = $path;
        }

        $section->lectures()->create($lectureData);

        return back()->with('success', 'Lecture added successfully');
    }

    public function destroy(CourseLecture $lecture)
    {
        if ($lecture->video_file && Storage::disk('public')->exists($lecture->video_file)) {
            Storage::disk('public')->delete($lecture->video_file);
        }
        $lecture->delete();

        return back()->with('success', 'Lecture deleted successfully');
    }
}
