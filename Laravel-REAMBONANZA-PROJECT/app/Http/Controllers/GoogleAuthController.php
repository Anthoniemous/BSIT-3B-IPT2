<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    // 🔹 Step 1: Redirect user to Google
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()  // Use stateless to avoid session issues
            ->with(['prompt' => 'select_account']) // Force account chooser every time (change to 'none' to skip)
            ->redirect();
    }

    // 🔹 Step 2: Handle callback from Google
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create new user if not existing
                $user = User::create([
                    'name'               => $googleUser->getName(),
                    'email'              => $googleUser->getEmail(),
                    'google_id'          => $googleUser->getId(),
                    'avatar'             => $googleUser->getAvatar(),
                    'password'           => bcrypt(str()->random(16)), // Dummy password
                    'email_verified_at'  => now(), // Auto-verify
                ]);
            } else {
                // Update existing user info (optional but useful)
                $user->update([
                    'name'               => $googleUser->getName(),
                    'google_id'          => $googleUser->getId(),
                    'avatar'             => $googleUser->getAvatar(),
                    'email_verified_at'  => $user->email_verified_at ?? now(),
                ]);
            }

            // Log in the user
            Auth::login($user);

            // Redirect to dashboard
            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->withErrors([
                'msg' => 'Something went wrong with Google login: ' . $e->getMessage()
            ]);
        }
    }
}
