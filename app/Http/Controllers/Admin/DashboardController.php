<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student\Course\Enrollment;
use App\Models\Teacher\Course\Course;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $pendingCourses = Course::where('status', 'pending')->count();

        $totalEnrollments = Enrollment::count();

        $totalCourses = Course::count();

        $totalTeachers = User::where('role', 'teacher')->count();
        $totalStudents = User::where('role', 'student')->count();

        return view('admin.dasboard', compact(
            'pendingCourses',
            'totalEnrollments',
            'totalCourses',
            'totalTeachers',
            'totalStudents',
        ));
    }
}