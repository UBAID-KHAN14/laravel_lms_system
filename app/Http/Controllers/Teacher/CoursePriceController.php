<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher\Course\Course;
use App\Models\Teacher\Course\Pricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoursePriceController extends Controller
{

    // Store pricing
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'currency' => 'required|string',
            'currency_symbol' => 'required|string',
            'price' => 'required|integer|min:0',
        ]);


        $course = Course::where('id', $request->course_id)
            ->where('teacher_id', Auth::id())
            ->firstOrFail();


        Pricing::updateOrCreate(
            ['course_id' => $course->id],
            [
                'price' => $request->price,
                'currency' => $request->currency,
                'currency_symbol' => $request->currency_symbol
            ]
        );

        return redirect()->back()->with('success', 'Pricing added successfully');
    }

    // Delete pricing
    public function destroy(Pricing $pricing)
    {

        if ($pricing->course->teacher_id != Auth::id()) {
            abort(403);
        }

        $pricing->delete();

        return redirect()->back()->with('success', 'Pricing deleted successfully');
    }
}
