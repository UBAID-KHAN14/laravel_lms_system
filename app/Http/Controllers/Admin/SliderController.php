<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::orderBy('id', 'ASC')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:10240',
        ]);



        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sliders', 'public');
        }


        $slider = new Slider();

        $slider->title = trim($request->title);
        $slider->description = trim($request->description);
        $slider->status = $request->boolean('status');
        $slider->image = $imagePath;

        $slider->save();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slider = Slider::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:10240',
        ]);


        if ($request->hasFile('image')) {
            // Delete old one
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }
            // Store new one
            $slider->image = $request->file('image')->store('sliders', 'public');
        }
        $slider->title = trim($request->title);
        $slider->description = trim($request->description);
        $slider->status = $request->boolean('status');
        $slider->save();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        // delete image if exists
        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider Deleted Successfully.');
    }
}