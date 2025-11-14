<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_id', $google_user->getId())->first();

            if (!$user) {
                // Create new user if not existing
                $new_user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                ]);

                Auth::login($new_user);
            } else {
                // Log in existing user
                Auth::login($user);
            }

            // ✅ Redirect to /home instead of /dashboard
            return redirect()->intended('/home');

        } catch (\Throwable $th) {
            // Optional: show user-friendly message
            return redirect()->route('login')->with('error', 'Google login failed. Please try again.');
        }
    }
}
