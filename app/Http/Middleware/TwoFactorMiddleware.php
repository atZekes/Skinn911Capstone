<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // If user is authenticated and has 2FA enabled
        if ($user && $user->google2fa_enabled) {
            // Check if they've verified 2FA this session
            if (!session('2fa_verified')) {
                // Allow access to 2FA routes
                if ($request->route()->named('two-factor.verify') ||
                    $request->route()->named('two-factor.verify.post') ||
                    $request->route()->named('logout')) {
                    return $next($request);
                }

                // Redirect to 2FA verification
                return redirect()->route('two-factor.verify');
            }
        }

        return $next($request);
    }
}
