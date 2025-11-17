<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\GoogleAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('guest')->group(function () {
    // Redirect GET /register to home page as registration is handled via modal on client UI
    Route::get('register', function() {
        return redirect('/');
    });

    // Keep POST /register to handle registration submissions; name route 'register' for form action
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');

    // Redirect GET /login to home page as login is handled via modal on client UI
    Route::get('login', function() {
        return redirect('/');
    });

    // Keep POST /login to handle login submissions (form action for modal)
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');

    // Google OAuth routes (commented out)
    // Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
    // Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

    // Alternative: Route-based Google OAuth (less recommended)
    // Route::get('auth/google', function () {
    //     return Socialite::driver('google')->redirect();
    // })->name('auth.google');
    //
    // Route::get('auth/google/callback', function () {
    //     try {
    //         $googleUser = Socialite::driver('google')->user();
    //
    //         $user = User::updateOrCreate([
    //             'email' => $googleUser->getEmail(),
    //         ], [
    //             'name' => $googleUser->getName(),
    //             'email' => $googleUser->getEmail(),
    //             'password' => Hash::make(uniqid()),
    //             'email_verified_at' => now(),
    //         ]);
    //
    //         Auth::login($user);
    //         return redirect()->intended(route('client.home'));
    //     } catch (\Exception $e) {
    //         return redirect()->route('login')->with('error', 'Google authentication failed. Please try again.');
    //     }
    // });

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Email verification link - no auth required (for cross-device verification)
Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('verification/check', function () {
        return response()->json([
            'verified' => Auth::user()->hasVerifiedEmail()
        ]);
    })->name('verification.check');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
