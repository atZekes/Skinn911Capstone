<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TwoFactorController extends Controller
{
    protected $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    /**
     * Show 2FA setup page
     */
    public function showSetup()
    {
        $user = Auth::user();

        // Generate secret key if not exists
        if (!$user->google2fa_secret) {
            $secret = $this->google2fa->generateSecretKey();
            $user->google2fa_secret = $secret;
            $user->save();
        }

        // Generate QR Code URL
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        return view('auth.two-factor-setup', [
            'qrCodeUrl' => $qrCodeUrl,
            'secret' => $user->google2fa_secret,
            'enabled' => $user->google2fa_enabled
        ]);
    }

    /**
     * Enable 2FA
     */
    public function enable(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|numeric',
            'password' => 'required'
        ]);

        $user = Auth::user();

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Invalid password.']);
        }

        // Verify OTP
        $valid = $this->google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if (!$valid) {
            return back()->withErrors(['one_time_password' => 'Invalid verification code.']);
        }

        // Enable 2FA
        $user->google2fa_enabled = true;
        $user->google2fa_enabled_at = now();
        $user->save();

        return redirect()->back()->with('success', '2FA has been enabled successfully!');
    }

    /**
     * Disable 2FA
     */
    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'one_time_password' => 'required|numeric'
        ]);

        $user = Auth::user();

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Invalid password.']);
        }

        // Verify OTP
        $valid = $this->google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if (!$valid) {
            return back()->withErrors(['one_time_password' => 'Invalid verification code.']);
        }

        // Disable 2FA
        $user->google2fa_enabled = false;
        $user->google2fa_secret = null;
        $user->google2fa_enabled_at = null;
        $user->save();

        return redirect()->back()->with('success', '2FA has been disabled successfully!');
    }

    /**
     * Show 2FA verification page (after login)
     */
    public function showVerify()
    {
        return view('auth.two-factor-verify');
    }

    /**
     * Verify 2FA code during login
     */
    public function verify(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|numeric'
        ]);

        $user = Auth::user();

        if (!$user || !$user->google2fa_enabled) {
            return redirect()->route('login')->withErrors(['error' => 'Invalid session.']);
        }

        $valid = $this->google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if (!$valid) {
            return back()->withErrors(['one_time_password' => 'Invalid verification code. Please try again.']);
        }

        // Mark 2FA as verified in session
        session(['2fa_verified' => true]);

        // Redirect based on role
        if ($user->role === 'admin' || $user->role === 'superadmin') {
            return redirect()->route('admin.home');
        } elseif ($user->role === 'ceo') {
            return redirect()->route('ceo.dashboard');
        } elseif ($user->role === 'staff') {
            return redirect()->route('staff.home');
        } else {
            return redirect()->route('client.home');
        }
    }
}
