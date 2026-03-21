<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\AccountActivationMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use function Symfony\Component\Clock\now;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // VALIDATION
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'requested_as' => 'required|in:teacher,student',

            // Teacher fields
            'qualification' => 'nullable|required_if:requested_as,teacher|string|max:255',
            'experience'    => 'nullable|required_if:requested_as,teacher|integer|min:0',

            // Student fields
            'roll_number' => 'nullable|required_if:requested_as,student|string|max:50',
            'class_name'  => 'nullable|required_if:requested_as,student|string|max:50',
            'father_name' => 'nullable|string|max:255',

            // Common fields
            'gender' => 'nullable|in:male,female',
            'phone'  => 'nullable|string|max:20',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // HANDLE IMAGE UPLOAD
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->store('users', 'public');
        }

        // CREATE USER
        $user = new User();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->requested_as = trim($request->requested_as);
        $user->is_active = false;
        $user->activation_token = Str::random(64);
        $user->activation_token_expires_at = Carbon::now()->addHour(24);
        $user->gender = $request->gender;
        $user->phone = trim($request->phone);
        $user->image = $imageName;

        // ROLE SPECIFIC FIELDS
        if ($request->requested_as === 'teacher') {
            $user->qualification = trim($request->qualification);
            $user->experience = trim($request->experience);

            // Empty student fields
            $user->roll_number = null;
            $user->class_name = null;
            $user->father_name = null;
        }

        if ($request->requested_as === 'student') {
            $user->roll_number = trim($request->roll_number);
            $user->class_name = trim($request->class_name);
            $user->father_name = trim($request->father_name);

            // Empty teacher fields
            $user->qualification = null;
            $user->experience = null;
        }

        $user->save();

        // SEND ACTIVATION EMAIL
        Mail::to($user->email)->send(new AccountActivationMail($user));

        event(new Registered($user));

        return redirect()->route('login')->with([
            'alert_type' => 'success',
            'alert_title' => 'Created',
            'alert_message' => 'Registration successful! Awaiting approval.',
        ]);
    }
}
