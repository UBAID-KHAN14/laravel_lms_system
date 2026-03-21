<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student\Course\Enrollment;
use App\Models\Teacher\Course\Course;
use App\Models\User;
use App\Notifications\CourseApprovedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AdminController extends Controller
{


    public function index()
    {
        $courses = Course::with(['user', 'category', 'subCategory'])->where('status', '!=', 'draft')->get();
        return view('admin.course_approvals.index', compact('courses'));
    }

    public function approve(Course $course)
    {
        $course->status = 'published';
        $course->published_at = now();
        $course->rejected_at = null;
        $course->rejection_reason = null;
        $course->save();
        // Notify teacher about approval
        if ($course->user) {
            $course->user->notify(new CourseApprovedMail($course));
        } else {
            Log::warning("Course {$course->id} has no user (teacher_id={$course->teacher_id}) - approval notification skipped.");
        }

        return redirect()->route('admin.course_approvals.index')->with('success', 'Course approved successfully.');
    }

    public function reject(Request $request, Course $course)
    {
        $course->status = 'rejected';
        $course->rejected_at = now();
        $course->published_at = null;
        $course->rejection_reason = $request->rejection_reason;
        $course->save();

        // Notify teacher about rejection
        if ($course->user) {
            $course->user->notify(new CourseApprovedMail($course));
        } else {
            Log::warning("Course {$course->id} has no user (teacher_id={$course->teacher_id}) - rejection notification skipped.");
        }

        return redirect()->route('admin.course_approvals.index')->with('success', 'Course rejected successfully.');
    }

    // COURSE OVERIEW SPECIFIC ID
    public function courses_overview($id)
    {
        $course = Course::with(['user', 'category', 'subCategory', 'sections', 'lectures.materials', 'faqs'])->findOrFail($id);
        return view('admin.courses_overview.courses_overview', compact('course'));
    }

    // SHOW ALL COURSES ENROLL
    public function course_enroll_all()
    {
        $enrollments = Enrollment::with(['course', 'user'])->latest()->get();
        return view('admin.courses_enroll.index', compact('enrollments'));
    }

    // UPDATE THE ENROLLMENT IS_ACTIVE
    public function course_enroll_update(Request $request, $id)
    {
        $request->validate([
            'is_active' => 'required|in:0,1',
        ]);
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->is_active = $request->is_active;
        $enrollment->save();

        return redirect()->back()->with('success', 'Enrollment Updated Successfully.');
    }
}
