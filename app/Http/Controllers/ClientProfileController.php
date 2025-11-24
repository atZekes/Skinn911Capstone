<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientProfileController extends Controller
{
    // Show the edit form
    public function edit()
    {
        $user = Auth::user();

        // Load claimed promos with promo details and branch info, excluding used ones
        $claimedPromos = $user->promoClaims()
            ->with(['promo.branch'])
            ->whereDoesntHave('promo.usages', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->orderBy('claimed_at', 'desc')
            ->get();

        return view('Client.profile_edit', [
            'user' => $user,
            'claimedPromos' => $claimedPromos
        ]);
    }

    // Handle update
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile_phone' => 'nullable|string|max:30',
            'telephone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:1000',
            'birthday' => 'nullable|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'preferences' => 'nullable|array',
            'preferences.*' => 'string|in:Facial,Laser,Slimming,Immuno,Hair Removal',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->mobile_phone = $validated['mobile_phone'] ?? null;
        $user->telephone = $validated['telephone'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->birthday = $validated['birthday'] ?? null;
        $user->preferences = $validated['preferences'] ?? [];
        $user->save();

        return redirect()->route('client.profile.edit')->with('success', 'Profile updated.');
    }
}
