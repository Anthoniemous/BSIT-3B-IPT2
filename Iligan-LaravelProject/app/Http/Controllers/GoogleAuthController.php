<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to Google for authentication.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the Google callback.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Try to find an existing user via google_id or email
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if ($user) {
                /**
                 * 🟢 EXISTING USER LOGGING IN VIA GOOGLE
                 * - Skip email verification
                 * - Just update google_id if not yet linked
                 */
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                    ]);
                }

                Auth::login($user);
                return redirect()->intended('/dashboard');
            } 
            else {
                /**
                 * 🟡 NEW USER REGISTERING VIA GOOGLE
                 * - Create account
                 * - Require email verification (email_verified_at = null)
                 * - Send verification email
                 */
                $fullName = explode(' ', $googleUser->getName(), 2);
                $fname = $fullName[0] ?? '';
                $lname = $fullName[1] ?? '';

                $user = User::create([
                    'fname'             => $fname,
                    'lname'             => $lname,
                    'email'             => $googleUser->getEmail(),
                    'google_id'         => $googleUser->getId(),
                    'password'          => Hash::make(Str::random(24)),
                    'email_verified_at' => null, // user must verify first
                ]);

                // Send email verification if the model uses MustVerifyEmail
                if (in_array('Illuminate\Contracts\Auth\MustVerifyEmail', class_implements($user))) {
                    $user->sendEmailVerificationNotification();
                }

                // Log the user in but redirect them to verification page
                Auth::login($user);

                return redirect()->route('verification.notice')
                    ->with('status', 'Please verify your email before continuing.');
            }

        } catch (\Throwable $th) {
            return redirect()->route('login')
                ->with('error', 'Google login failed: ' . $th->getMessage());
        }
    }
}
