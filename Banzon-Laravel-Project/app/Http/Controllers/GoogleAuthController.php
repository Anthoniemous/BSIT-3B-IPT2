<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    // 🔹 Step 1: send user to Google login
    public function redirect()
    {
        return Socialite::driver('google')
        ->redirectUrl(config('services.google.redirect'))
        ->redirect();
    }

    // 🔹 Step 2: handle Google callback
    public function callbackGoogle()
    {
        try {
            $google_user = Socialite::driver('google')->user();

            // Try to find by google_id OR email
            $user = User::where('google_id', $google_user->getId())
                        ->orWhere('email', $google_user->getEmail())
                        ->first();

            if (!$user) {
                $user = User::create([
                    'name'      => $google_user->getName(),
                    'email'     => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                    'password'  => bcrypt(Str::random(16)), // dummy password
                ]);
            } else {
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $google_user->getId(),
                    ]);
                }
            }

            Auth::login($user);
            return redirect()->intended('dashboard');

        } catch (\Throwable $th) {
            dd('Something went wrong: ' . $th->getMessage());
        }
    }
}
