<?php

namespace App\Http\Controllers\Student\Course;

use App\Http\Controllers\Controller;
use App\Models\Student\Course\Enrollment;
use App\Models\Teacher\Course\Course;
use App\Models\Teacher\Course\CourseLecture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Illuminate\Support\now;

class EnrollmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = Auth::user();

        // if already enrolled
        if (Enrollment::where('user_id', $user->id)->where('course_id', $request->course_id)->exists()) {

            return back()->with('info', 'Already Enrolled');
        }

        $enroll = new Enrollment();
        $enroll->user_id = $user->id;
        $enroll->course_id = $request->course_id;
        $enroll->enrolled_at = now();
        $enroll->status = 'pending';


        $enroll->save();

        return redirect()->back()->with('success', 'Student Enroll Successfully. Awaiting for approval!');
    }

    //  Continue Learning - Show course learning page
    public function learn($courseId)
    {
        // Get the course with sections and lectures
        $course = Course::with([
            'sections' => function ($query) {
                $query->orderBy('order_number');
            },
            'sections.lectures',
        ])->findOrFail($courseId);

        // Get the requested lecture ID from query parameter or default to first lecture
        $lectureId = request()->get('lecture');
        $currentLecture = null;

        if ($lectureId) {
            $currentLecture = CourseLecture::find($lectureId);
        } else {
            // Get first lecture of the course
            $firstSection = $course->sections->first();
            if ($firstSection && $firstSection->lectures->isNotEmpty()) {
                $currentLecture = $firstSection->lectures->first();
            }
        }

        // Calculate total lectures
        $totalLectures = $course->sections->sum(function ($section) {
            return $section->lectures->count();
        });

        return view('student.courses.learn', compact(
            'course',
            'currentLecture',
            'totalLectures'
        ));
    }
}
