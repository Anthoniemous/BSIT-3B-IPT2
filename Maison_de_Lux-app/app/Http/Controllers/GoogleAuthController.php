<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Handle callback from Google after user has been redirected
     * back from Google after attempting to log in.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
/*******  25b8551d-4264-4674-8718-d1f2ba9d9309  *******/    public function callbackGoogle()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google login failed.');
        }

        // Check if user exists by email
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // User exists - link Google account if not yet linked
            if (!$user->google_id) {
                $user->google_id = $googleUser->getId();
                $user->email_verified_at = now();
                $user->save();
            }

            // Log the user in
            Auth::login($user);

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('dashboard');

        } else {
            // ✅ CHANGE: User doesn't exist - redirect to register page
            return redirect()->route('register')
                ->with('error', 'No account found. Please register first before using Google login.')
                ->with('google_email', $googleUser->getEmail())
                ->with('google_name', $googleUser->getName());
        }
    }
}