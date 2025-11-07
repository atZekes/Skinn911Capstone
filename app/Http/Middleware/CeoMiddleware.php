<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CeoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Step 1: Check if user is logged in using ceo guard
        if (!Auth::guard('ceo')->check()) {
            // If not logged in, send to CEO login page
            return redirect('/ceo/login')->with('error', 'Please login first');
        }

        // Step 2: Get the logged in CEO user
        $user = Auth::guard('ceo')->user();

        // Step 3: Check if user is CEO (has role 'ceo')
        if ($user->role !== 'ceo') {
            // If not CEO, show error message
            Auth::guard('ceo')->logout();
            return redirect('/ceo/login')->with('error', 'Only CEO accounts can access this area');
        }

        // Step 4: If everything is OK, let the user continue
        return $next($request);
    }
}
