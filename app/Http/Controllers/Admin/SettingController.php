<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'   => 'required|string|max:255',
            'site_email'   => 'required|email|max:255',
            'site_phone'   => 'required|string|max:20',
            'site_address' => 'required|string|max:255',

            'logo'         => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'favicon'      => 'nullable|image|mimes:png,ico|max:1024',
        ]);

        // it means if one thing fail it will not save data
        DB::transaction(function () use ($request) {
            $setting = Setting::firstOrCreate([]);

            foreach (['logo', 'favicon'] as $file) {
                if ($request->hasFile($file)) {

                    // DELETE THE OLD 
                    if ($setting->$file && Storage::disk('public')->exists($setting->$file)) {
                        Storage::disk('public')->delete($setting->$file);
                    }

                    // STORE NEW ONE
                    $setting->$file = $request->file($file)->store('settings', 'public');
                }
            }

            $setting->site_name   = trim($request->site_name);
            $setting->site_email   = trim($request->site_email);
            $setting->site_phone   = trim($request->site_phone);
            $setting->site_address = trim($request->site_address);

            $setting->save();
        });

        return redirect()->back()->with('success', 'System Setting updated successfully!');
    }
}