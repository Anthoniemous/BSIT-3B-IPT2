<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User; // ✅ import User model
use Illuminate\Support\Facades\Auth; // ✅ import Auth facade

class GoogleAuthController extends Controller
{
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            $google_user = Socialite::driver('google')->stateless()->user(); // ✅ use stateless() if callback breaks

            // Find user by google_id
            $user = User::where('google_id', $google_user->getId())->first();

            if (!$user) {
                // Create new user if not exists
                $new_user = User::create([
                    'name'      => $google_user->getName(),
                    'email'     => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                    'password'  => bcrypt(str()->random(16)), // ✅ to avoid null password
                ]);

                Auth::login($new_user, true);

                return redirect()->intended('/dashboard');
            } else {
                // Login existing user
                Auth::login($user);

                return redirect()->intended('/dashboard');
            }
        } catch (\Throwable $th) {
            dd('Something went wrong! ' . $th->getMessage());
        }
    }
}
