<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(Request $request, $id, $hash): RedirectResponse
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Verify the hash matches
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link.');
        }

        // Check if link has expired (60 minutes)
        if (! $request->hasValidSignature()) {
            // If email is not verified yet, send a new verification email
            if (! $user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();
                Auth::login($user);
                return redirect()->route('client.home')->with('info', 'Verification link expired. We\'ve sent you a new verification email! 📧');
            }
            
            // If already verified, just log them in
            Auth::login($user);
            return redirect()->route('client.home')->with('success', 'Your email is already verified!');
        }

        // If already verified, just redirect
        if ($user->hasVerifiedEmail()) {
            Auth::login($user);
            return redirect()->route('client.home')->with('success', 'Your email is already verified!');
        }

        // Mark as verified
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Log the user in automatically
        Auth::login($user);

        return redirect()->route('client.home')->with('verified', 1);
    }
}
