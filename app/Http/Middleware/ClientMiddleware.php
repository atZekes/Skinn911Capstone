<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Step 1: Check if user is logged in using web guard
        if (!Auth::guard('web')->check()) {
            // If not logged in, send to login page
            return redirect('/login')->with('error', 'Please login first');
        }

        // Step 2: Get the logged in client user
        $user = Auth::guard('web')->user();

        // Step 3: Check if user is client (has role 'client')
        if ($user->role !== 'client') {
            // If not client, show error message
            Auth::guard('web')->logout();
            return redirect('/login')->with('error', 'Only client accounts can access this area');
        }

        // Step 4: If everything is OK, let the user continue
        return $next($request);
    }
}
