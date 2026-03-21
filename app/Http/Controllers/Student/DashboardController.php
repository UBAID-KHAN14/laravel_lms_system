<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Teacher\Course\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('student.dashboard');
    }

    public function my_courses()
    {
        $user = Auth::user();

        $courses = $user->enrolledCourses()->with('user')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->get(); // teacher->get();
        return view('student.dashboard.my_course', compact('courses'));
    }
}