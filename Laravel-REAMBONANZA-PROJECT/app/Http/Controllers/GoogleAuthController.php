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
        return Socialite::driver('google')->redirect();
    }

    // 🔹 Step 2: Handle callback from Google
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create new user if not existing
                $user = User::create([
                    'name'     => $googleUser->getName(),
                    'email'    => $googleUser->getEmail(),
                    'password' => bcrypt(str()->random(16)), // random dummy password
                    'email_verified_at' => now(), // auto-verify email since Google is trusted
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
