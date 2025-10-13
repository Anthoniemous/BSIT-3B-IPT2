<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\Admin; // ✅ use Admin instead of Customer
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    // 🔹 Step 1: Redirect to Google for authentication
    public function redirect()
    {
        return Socialite::driver('google')
            ->redirectUrl(config('services.google.redirect'))
            ->redirect();
    }

    // 🔹 Step 2: Handle Google callback
    public function callbackGoogle()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find the admin by Google ID or email
            $admin = Admin::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            // Create new admin if not found
            if (!$admin) {
                $admin = Admin::create([
                    'username'  => $googleUser->getName(),  // ✅ matches admin table
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password'  => bcrypt(Str::random(16)), // dummy password
                ]);
            } else {
                // Update Google ID if missing
                if (!$admin->google_id) {
                    $admin->update([
                        'google_id' => $googleUser->getId(),
                    ]);
                }
            }

            // Login as admin (default guard)
            Auth::login($admin);

            return redirect()->intended('/dashboard');

        } catch (\Throwable $th) {
            dd('Something went wrong: ' . $th->getMessage());
        }
    }
}
