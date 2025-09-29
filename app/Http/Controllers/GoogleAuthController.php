<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User; // make sure you import your User model

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $google_user = Socialite::driver('google')->user();

            // Check if user already exists
            $user = User::where('google_id', $google_user->getId())->first();

            if (!$user) {
                // If not, create a new one
                $new_user = User::create([
                    'name'      => $google_user->getName(),
                    'email'     => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                    'password'  => bcrypt('123456dummy') // dummy password
                ]);

                Auth::login($new_user);

                return redirect()->intended('dashboard');
            } else {
                // If user exists, just log in
                Auth::login($user);

                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $th) {
            return redirect()->route('login')->with('error', 'Something went wrong!');
        }
    }
}
