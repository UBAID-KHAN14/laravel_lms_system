<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (Auth::check() && !Auth::user()->is_active) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')
                ->with([
                    'alert_type' => 'error',
                    'alert_title' => 'Logout',
                    'alert_message' => 'Your account has been deactivated by admin.'
                ]);
        }

        if (!in_array(Auth::user()->role, $roles)) {
            // abort(403, "You don't have permission to access this page.");
            return back()->with("error", "You don't have permission to access this page.");
        }

        return $next($request);
    }
}
