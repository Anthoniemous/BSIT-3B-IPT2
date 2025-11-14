<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        return view('profile.profile', compact('user'));
    }
public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    
    // Update name and email
    $user->fill($request->validated());

    // Handle optional password update
    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    // Handle avatar upload
    if ($request->hasFile('avatar')) {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $user->avatar = $request->file('avatar')->store('avatars', 'public');
    }

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/'); // Redirect guests to main homepage
    }
}
