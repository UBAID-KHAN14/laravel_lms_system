<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SocialLinkController extends Controller
{
    public function index()
    {
        $socialLinks = SocialLink::all();
        return view('admin.social-links.index', compact('socialLinks'));
    }
    public function create()
    {
        return view('admin.social-links.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required',
            'icon_class' => 'required',
            'status' => 'required|in:0,1',
        ]);

        $socialLink = new SocialLink();
        $socialLink->name = $request->name;
        $socialLink->url = $request->url;
        $socialLink->icon_class = $request->icon_class;
        $socialLink->status = $request->boolean('status');

        $socialLink->save();
        return redirect()->route('admin.socialLinks.index')->with('success', 'Social Link Created Successfully!');
    }

    public function edit(string $id)
    {
        $socialLink = SocialLink::findOrFail($id);
        return view('admin.social-links.edit', compact('socialLink'));
    }

    public function update(Request $request, string $id)
    {
        $socialLink = SocialLink::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required',
            'icon_class' => 'required',
            'status' => 'required|in:0,1',
        ]);

        $socialLink->name = $request->name;
        $socialLink->url = $request->url;
        $socialLink->icon_class = $request->icon_class;
        $socialLink->status = $request->boolean('status');

        $socialLink->save();
        return redirect()->route('admin.socialLinks.index')->with('success', 'Social Link Updated Successfully!');
    }

    public function destroy(string $id)
    {
        $socialLink = SocialLink::findOrFail($id);

        $socialLink->delete();
        return redirect()->route('admin.socialLinks.index')->with([
            'alert_type' => 'success',
            'alert_title' => 'Deleted',
            'alert_message' => 'Social Link Deleted Successfully!'
        ]);
    }
}
