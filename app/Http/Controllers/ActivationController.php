<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountActivationMail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivationController extends Controller
{
    public function activate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with([
                'alert_type' => 'error',
                'alert_title' => 'Invalid!',
                'alert_message' => 'Invalid activation link.',
            ]);
        }

        if (Carbon::parse($user->activation_token_expires_at)->isPast()) {
            return redirect()->route('login')->with([
                'alert_type' => 'error',
                'alert_title' => 'Expired!',
                'alert_message' => 'Activation link expired. Please resend.',
            ]);
        }

        $user->update([
            'is_active' => true,
            'activation_token' => null,
            'activation_token_expires_at' => null,
        ]);

        return redirect()->route('login')->with([
            'alert_type' => 'success',
            'alert_title' => 'Activated!',
            'alert_message' => 'Account activated successfully!',
        ]);
    }

    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)
            ->where('is_active', false)
            ->first();

        if (!$user) {
            return redirect()->back()->with([
                'alert_type' => 'error',
                'alert_title' => 'Not Found!',
                'alert_message' => 'Account already activated or not found.',
            ]);
        }

        $user->update([
            'activation_token' => Str::random(64),
            'activation_token_expires_at' => Carbon::now()->addHours(24),
        ]);

        Mail::to($user->email)->send(new AccountActivationMail($user));

        return back()->with([
            'alert_type' => 'success',
            'alert_title' => 'Resent!',
            'alert_message' => 'Activation email resent successfully.',
        ]);
    }
}
