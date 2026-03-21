<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermAndPrivacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TermAndPrivacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $termAndPrivacies = TermAndPrivacy::orderBy('sort_order')->get();
        return view('admin.term_privacy.index', compact('termAndPrivacies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.term_privacy.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sections' => 'required|array|min:1',
            'sections.*.type' => 'required|in:privacies,terms',
            'sections.*.heading' => 'required|string',
            'sections.*.body' => 'required|string',
            'sections.*.sort_order' => 'required|integer',
            'sections.*.status' => 'required|boolean',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->sections as $section) {

                $termPrivacy = new TermAndPrivacy([]);
                $termPrivacy->type = $section['type'];
                $termPrivacy->heading = $section['heading'];
                $termPrivacy->body = $section['body'];
                $termPrivacy->sort_order = $section['sort_order'];
                $termPrivacy->status = $section['status'];

                $termPrivacy->save();
            }
        });
        return redirect()->route('admin.term_privacy.index')->with('success', 'TermPrivacy sections saved successfully!');
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
        $termPrivacy = TermAndPrivacy::findOrFail($id);
        return view('admin.term_privacy.edit', compact('termPrivacy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $termPrivacy = TermAndPrivacy::findOrFail($id);
        $request->validate([
            'type' => 'required|in:privacies,terms',
            'heading' => 'required|string',
            'body' => 'required|string',
            'sort_order' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        $termPrivacy->type = $request->type;
        $termPrivacy->heading = $request->heading;
        $termPrivacy->body = $request->body;
        $termPrivacy->sort_order = $request->sort_order;
        $termPrivacy->status = $request->status;

        $termPrivacy->save();
        return redirect()->route('admin.term_privacy.index')->with('success', 'TermPrivacy section Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $termPrivacy = TermAndPrivacy::findOrFail($id);
        $termPrivacy->delete();
        return redirect()->route('admin.term_privacy.index')->with('success', 'TermPrivacy section Deleted successfully!');
    }
}
