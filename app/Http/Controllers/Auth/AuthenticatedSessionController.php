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
public function store(LoginRequest $request): RedirectResponse
{
    try {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // Check if 2FA is enabled for this user
        if ($user && $user->google2fa_enabled) {
            // Clear 2FA verification status
            session()->forget('2fa_verified');
            // Redirect to 2FA verification
            return redirect()->route('two-factor.verify');
        }

        // Check if email verification is required
        if ($user && !$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // No 2FA and email verified, redirect to appropriate home based on role
        return redirect()->route('client.home');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Redirect back with error message
        return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Login failed: ' . ($e->errors()['email'][0] ?? 'Unknown error'));
    }
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home', ['showLogin' => 1])->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
