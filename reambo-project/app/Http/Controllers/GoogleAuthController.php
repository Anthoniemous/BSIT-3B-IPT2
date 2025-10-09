<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleAuthController extends Controller
{
    // Step 1: Redirect to Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Step 2: Handle callback from Google
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt('password'), // dummy password
            ]);

            Auth::login($user);

            return redirect('/')->with('success', 'Welcome back, ' . $user->name . '!');
        } catch (Exception $e) {
            return redirect('/')->with('error', 'Something went wrong. Try again!');
        }
    }
}
