<?php

namespace App\Http\Controllers\Teacher\Course;

use App\Http\Controllers\Controller;
use App\Models\Student\Course\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        // Get students enrolled in teacher's courses
        $enrollments = Enrollment::with([
            'user',   // student
            'course'  // course
        ])
            ->whereHas('course', function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            })

            ->latest()
            ->get();

        return view('teacher.course.enrollments.index', compact('enrollments'));
    }

    // STATUS
    public function status_update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved',
        ]);
        $enroll = Enrollment::findOrFail($id);
        $enroll->status = $request->status;
        $enroll->save();

        return redirect()->back()->with('success', 'Enrollment Status Updated Successfully.');
    }

    // IS ACTIVATION
    public function activation_update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:0,1',
        ]);
        $enroll = Enrollment::findOrFail($id);
        $enroll->is_active = $request->is_active;
        $enroll->save();

        return redirect()->back()->with('success', 'Enrollment Activation Updated Successfully.');
    }
}
