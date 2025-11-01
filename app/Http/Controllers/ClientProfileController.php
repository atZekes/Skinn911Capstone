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
        return view('Client.profile_edit', ['user' => $user]);
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
            'birthday' => 'nullable|date',
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
