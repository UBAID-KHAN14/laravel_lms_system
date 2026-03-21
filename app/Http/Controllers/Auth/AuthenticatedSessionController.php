<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return back()->with([
                'alert_type' => 'error',
                'alert_title' => 'Blocked',
                'alert_message' => 'Invalid Credentials',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return back()->with([
                'alert_type' => 'error',
                'alert_title' => 'Activation Required',
                'alert_message' => 'Please activate your account via email.',
                'show_resend_activation' => true,
                'email' => $credentials['email'],
            ]);
        }

        if (!$user->role) {
            Auth::logout();
            return back()->with([
                'alert_type' => 'error',
                'alert_title' => 'Not Assigned',
                'alert_message' => 'Role not assigned. Contact admin.',
            ]);
        }


        return match ($user->role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'teacher' => redirect()->route('home.index'),
            'student' => redirect()->route('home.index'),
            default   => redirect()->route('login')->with([
                'alert_type' => 'error',
                'alert_title' => 'Approval',
                'alert_message' => 'Wait for approval',
            ]),
        };

        // if (Auth::attempt($credentials) && Auth::user()->is_active && Auth::user()->role) {
        //     # code...
        // }
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with([
            'alert_type' => 'success',
            'alert_title' => 'Deleted',
            'alert_message' => 'Account Deleted Successfully.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with([
            'alert_type' => 'success',
            'alert_title' => 'Logout',
            'alert_message' => 'Logout Successfully.',
        ]);
    }
}