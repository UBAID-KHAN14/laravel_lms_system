<?php

namespace App\Http\Controllers\Student\Course;

use App\Http\Controllers\Controller;
use App\Models\Student\Course\CourseComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'comment' => 'required|string',
            'parent_id' => 'nullable|exists:course_comments,id'
        ]);

        CourseComment::create([
            'user_id' => Auth::id(),
            'course_id' => $courseId,
            'parent_id' => $request->parent_id,
            'comment' => $request->comment,
        ]);

        return back();
    }
}