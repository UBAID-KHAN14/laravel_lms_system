<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher\Course\CourseLecture;
use App\Models\Teacher\Course\LectureMaterial;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseLectureMaterialController extends Controller
{
    use AuthorizesRequests;

    // public function index()
    // {
    //     $lectureMaterials = LectureMaterial::whereHas('lecture.section.course', function ($query) {
    //         $query->where('teacher_id', Auth::id());
    //     })->with('lecture.section.course')->orderBy('lecture_id')->get();
    //     return view('teacher.materials.index', compact('lectureMaterials'));
    // }


    // public function create()
    // {
    //     $lectures = CourseLecture::whereHas('section.course', function ($query) {
    //         $query->where('teacher_id', Auth::id());
    //     })->get();
    //     return view('teacher.materials.create', compact('lectures'));
    // }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'lecture_id' => 'required|exists:course_lectures,id',
    //         'file_name' => 'required|file|max:10240',

    //     ]);

    //     $imageName = null;
    //     if ($request->hasFile('file_name')) {
    //         $imageName = $request->file('file_name')->store('lecture_materials', 'public');
    //     }

    //     $lectureMaterial = new LectureMaterial();
    //     $lectureMaterial->lecture_id = $request->lecture_id;
    //     $lectureMaterial->file_path = $imageName;
    //     $lectureMaterial->file_type = $request->file('file_name')->getClientMimeType();
    //     $lectureMaterial->file_name = $imageName;
    //     $lectureMaterial->save();
    //     return redirect()->route('teacher.course_lecture_materials.index')
    //         ->with('success', 'Lecture material uploaded successfully.');
    // }

    // public function edit(string $id)
    // {
    //     $lectureMaterial = LectureMaterial::findOrFail($id);
    //     $this->authorize('update', $lectureMaterial);

    //     $lectures = CourseLecture::whereHas('section.course', function ($query) {
    //         $query->where('teacher_id', Auth::id());
    //     })->get();

    //     return view('teacher.materials.edit', compact('lectureMaterial', 'lectures'));
    // }


    // public function update(Request $request, string $id)
    // {
    //     $request->validate([
    //         'lecture_id' => 'required|exists:course_lectures,id',
    //         'file_name' => 'sometimes|file|max:10240',
    //     ]);
    //     $lectureMaterial = LectureMaterial::findOrFail($id);
    //     $this->authorize('update', $lectureMaterial);

    //     if ($request->hasFile('file_name')) {

    //         if ($lectureMaterial->file_path && Storage::disk('public')->exists($lectureMaterial->file_path)) {
    //             Storage::disk('public')->delete($lectureMaterial->file_path);
    //         }
    //         $imageName = $request->file('file_name')->store('lecture_materials', 'public');
    //         $lectureMaterial->file_path = $imageName;
    //     }
    //     $lectureMaterial->lecture_id = $request->lecture_id;
    //     $lectureMaterial->file_path = $imageName;
    //     $lectureMaterial->file_type = $request->file('file_name')->getClientMimeType();
    //     $lectureMaterial->save();
    //     return redirect()->route('teacher.course_lecture_materials.index')
    //         ->with('success', 'Lecture material updated successfully.');
    // }


    // public function destroy(string $id)
    // {
    //     $lectureMaterial = LectureMaterial::findOrFail($id);
    //     $this->authorize('delete', $lectureMaterial);

    //     if ($lectureMaterial->file_path && Storage::disk('public')->exists($lectureMaterial->file_path)) {
    //         Storage::disk('public')->delete($lectureMaterial->file_path);
    //     }
    //     $lectureMaterial->delete();
    //     return redirect()->route('teacher.course_lecture_materials.index')
    //         ->with('success', 'Lecture material deleted successfully.');
    // }

    public function store(Request $request, $lectureId)
    {
        $request->validate([
            'materials.*' => 'required|file|max:51200',
        ]);

        foreach ($request->file('materials') as $file) {

            $path = $file->store('lecture-materials', 'public');

            LectureMaterial::create([
                'lecture_id' => $lectureId,
                'file_name'  => $file->getClientOriginalName(),
                'file_path'  => $path,
                'file_type'  => $file->getClientMimeType(),
            ]);
        }

        return back()->with('success', 'Materials uploaded successfully');
    }

    public function destroy(LectureMaterial $material)
    {
        $this->authorize('delete', $material);

        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return back()->with('success', 'Material deleted successfully');
    }
}
