<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Step 1: Check if user is logged in using admin guard
        if (!Auth::guard('admin')->check()) {
            // If not logged in, send to admin login page
            return redirect('/admin')->with('error', 'Please login first');
        }

        // Step 2: Get the logged in admin user
        $user = Auth::guard('admin')->user();

        // Step 3: Check if user is admin (has role 'admin')
        if ($user->role !== 'admin') {
            // If not admin, show error message
            Auth::guard('admin')->logout();
            return redirect('/admin')->with('error', 'Only admin accounts can access this area');
        }

        // Step 4: If everything is OK, let the user continue
        return $next($request);
    }
}
