<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
                // Check if user exists with same email
                $user = User::where('email', $google_user->getEmail())->first();

                if ($user) {
                    // Update existing user with google_id
                    $user->update(['google_id' => $google_user->getId()]);
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $google_user->getName(),
                        'email' => $google_user->getEmail(),
                        'google_id' => $google_user->getId(),
                        'password' => bcrypt('password123'), // Default password for Google OAuth users
                        'email_verified_at' => now() // Mark email as verified for Google OAuth users
                    ]);
                }
            }

            Auth::login($user);
            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
           return redirect()->route('login')->with('error', 'Google authentication failed. Please try again.');
        }
    }
}
