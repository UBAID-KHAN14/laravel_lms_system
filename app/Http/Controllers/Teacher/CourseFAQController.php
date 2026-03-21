<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher\Course\Course;
use App\Models\Teacher\Course\FAQ;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CourseFAQController extends Controller
{
    use AuthorizesRequests;
    public function index(Course $course)
    {
        return view('teacher.courses.faqs', [
            'course' => $course,
            'faqs'   => $course->faqs()->latest()->get(),
        ]);
    }

    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
        ]);

        $course->faqs()->create($data);

        return back()->with('success', 'FAQ added successfully');
    }

    public function update(Request $request, Course $course, FAQ $faq)
    {
        $this->authorize('update', $faq);

        $data = $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
        ]);

        $faq->update($data);

        return back()->with('success', 'FAQ updated successfully');
    }

    public function destroy(Course $course, FAQ $faq)
    {
        $this->authorize('delete', $faq);

        $faq->delete();

        return back()->with('success', 'FAQ deleted successfully');
    }

    public function saveFAQs(Request $request, Course $course)
    {
        $data = $request->validate([
            'faqs' => 'required|array|min:1',
            'faqs.*.question' => 'required|string|max:255',
            'faqs.*.answer'   => 'required|string',
        ]);

        $course->faqs()->delete();

        $course->faqs()->createMany($data['faqs']);

        return back()->with('success', 'FAQs saved successfully');
    }
}