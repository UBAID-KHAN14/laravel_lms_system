<?php

namespace App\Http\Controllers\Student\Course;

use App\Http\Controllers\Controller;
use App\Models\Student\Course\CourseReview;
use App\Models\Teacher\Course\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string'
        ]);

        CourseReview::updateOrCreate(
            [
                'user_id'   => Auth::id(),
                'course_id' => $courseId,
            ],
            [
                'rating' => $request->rating,
                'review' => $request->review
            ]
        );
        return back()->with('success', 'Review submitted!');
    }

    public function update(Request $request, $id)
    {
        $review = CourseReview::findOrFail($id);

        if ($review->user_id != Auth::id()) {
            abort(403);
        }

        $review->update([
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        return back();
    }

    public function destroy($id)
    {
        $review = CourseReview::findOrFail($id);

        if ($review->user_id != Auth::id()) {
            abort(403);
        }

        $review->delete();

        return back();
    }
}