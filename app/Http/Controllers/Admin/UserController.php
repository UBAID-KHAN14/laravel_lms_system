<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountActivationMail;
use App\Models\User;
use App\Notifications\UserStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('admin.users.index', compact('users'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update_user(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'requested_as' => 'required|in:teacher,student',
            'role' => 'required|in:admin,teacher,student',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle profile image
        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $user->image = $request->file('image')->store('users', 'public');
        }

        // Update basic info
        $user->name = trim($request->name);
        $user->role = trim($request->role);
        $user->requested_as = trim($request->requested_as);

        // Update email only if changed
        $emailChanged = false;
        if ($request->email && $request->email !== $user->email) {
            $user->email = $request->email;
            $user->is_active = false; // deactivate account if email changed
            $emailChanged = true;
        }

        // Update password only if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Send activation email if email changed
        if ($emailChanged) {
            try {
                Mail::to($user->email)->send(new AccountActivationMail($user));
                return back()->with('success', 'Email changed. Activation email sent.');
            } catch (\Exception $e) {
                return back()->with('error', 'Email could not be sent. Error: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'User updated successfully.');
    }


    // UPDATE IN THE LIST TABLE ROLE AND ACTIVATION
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role'      => 'sometimes|nullable|in:teacher,student',
            'status'    => 'sometimes|nullable|in:approved,rejected',
            'is_active' => 'sometimes|nullable|boolean',
        ]);


        if ($request->filled('role')) {
            $user->role = $request->role;
        }

        // if ($request->filled('status')) {
        //     $user->status = $request->status;
        // }

        if ($request->has('is_active')) {
            $user->is_active = $request->is_active;
        }

        $user->save();

        // $user->notify(new UserStatusChanged($request->status));
        return back()->with('success', 'User Updated Successfully.');
        // return back()->with([
        //     'alert_type' => 'success',
        //     'alert_title' => 'Updated',
        //     'alert_message' => 'User Updated Successfully.',
        // ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();
        return redirect()
            ->back()
            ->with([
                'alert_type' => 'success',
                'alert_title' => 'Deleted!',
                'alert_message' => 'User deleted successfully'
            ]);
    }
}
