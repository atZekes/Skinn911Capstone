<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Step 1: Check if user is logged in using staff guard
        if (!Auth::guard('staff')->check()) {
            // If not logged in, send to staff login page
            return redirect('/staff/login')->with('error', 'Please login first');
        }

        // Step 2: Get the logged in staff user
        $user = Auth::guard('staff')->user();

        // Step 3: Check if user is staff (has role 'staff') and is active
        if ($user->role !== 'staff') {
            // If not staff, show error message
            Auth::guard('staff')->logout();
            return redirect('/staff/login')->with('error', 'Only staff accounts can access this area');
        }

        // Step 4: Check if staff account is active
        if (!$user->active) {
            // If deactivated, logout and redirect
            Auth::guard('staff')->logout();
            return redirect('/staff/login')->with('error', 'Your account is deactivated');
        }

        // Step 5: If everything is OK, let the user continue
        return $next($request);
    }
}
