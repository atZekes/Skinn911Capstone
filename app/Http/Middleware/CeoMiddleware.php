<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CeoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Step 1: Check if user is logged in
        if (!Auth::check()) {
            // If not logged in, send to login page
            return redirect('/login')->with('error', 'Please login first');
        }

        // Step 2: Get the logged in user
        $user = Auth::user();

        // Step 3: Check if user is CEO (has role 'ceo')
        if ($user->role !== 'ceo') {
            // If not CEO, show error message
            return redirect('/')->with('error', 'You are not authorized to access CEO area');
        }

        // Step 4: If everything is OK, let the user continue
        return $next($request);
    }
}
