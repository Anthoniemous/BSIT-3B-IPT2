<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to Google's OAuth page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google.
     */
    public function callbackGoogle()
    {
        try {
            // Get user info from Google
            $google_user = Socialite::driver('google')->stateless()->user();

            // Check if the user already exists by Google ID or email
            $user = User::where('google_id', $google_user->getId())
                        ->orWhere('email', $google_user->getEmail())
                        ->first();

            if ($user) {
                // If user exists but doesn't have a google_id, update it
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $google_user->getId(),
                    ]);
                }

                // Log the user in
                Auth::login($user);
            } else {
                // Create a new user if not found
                $new_user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                    'password' => bcrypt(Str::random(16)), // secure random password
                ]);

                Auth::login($new_user);
            }

            // Redirect to dashboard or intended page
            return redirect()->intended('/dashboard');

        } catch (\Throwable $th) {
            // Optional: redirect with a friendly error message
            return redirect('/login')->with('error', 'Something went wrong! ' . $th->getMessage());
        }
    }
}
