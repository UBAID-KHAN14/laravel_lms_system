<?php

namespace App\Http\Controllers;


use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

use function PHPUnit\Framework\matches;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function index()
    {
        return view('profile_dashboard.index');
    }

    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users,email' . $id,
        ]);

        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $user->image = $request->file('image')->store('users', 'public');
        }

        $user->name = $request->name;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }



    public function password_update(Request $request)
    {
        try {
            $validated = $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Password::defaults()],
            ], [
                'current_password.current_password' => 'Your current password is incorrect.',
                'password.confirmed' => 'The new password confirmation does not match.',
            ]);

            if (Hash::check($validated['password'], $request->user()->password)) {
                return redirect()->back()->with('error', 'New password cannot be the same as the current password.');
            }

            // Update password
            $request->user()->update([
                'password' => Hash::make($validated['password']),
            ]);
            return redirect()->back()->with('success', 'Password updated successfully.');
        } catch (ValidationException $e) {
            $message = collect($e->errors())->flatten()->first();
            return redirect()->back()->with('error', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function destroy(Request $request)
    {
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->regenerate();
        $request->session()->regenerateToken();
        return redirect()->route('home.index');
    }
}