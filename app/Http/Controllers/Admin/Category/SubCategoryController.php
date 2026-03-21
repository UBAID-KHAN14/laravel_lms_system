<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sub_categories = SubCategory::with('category')->get();
        return view('admin.sub_category.index', compact('sub_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.sub_category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
        ]);

        $sub_category = new SubCategory();
        $sub_category->category_id = $request->category_id;
        $sub_category->name = trim($request->name);
        $sub_category->save();
        return redirect()->route('admin.sub_categories.index')->with('success', 'SubCategory Created Successfully.');
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
        $sub_category = SubCategory::findOrFail($id);
        $categories = Category::all();

        return view('admin.sub_category.edit', compact('sub_category', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sub_category = SubCategory::findOrFail($id);
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
        ]);

        $sub_category->category_id = $request->category_id;
        $sub_category->name = trim($request->name);
        $sub_category->save();
        return redirect()->route('admin.sub_categories.index')->with('success', 'SubCategory Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sub_category = SubCategory::findOrFail($id);
        $sub_category->delete();
        return redirect()->back()->with('success', 'SubCategory Deleted Successfully.');
    }
}
