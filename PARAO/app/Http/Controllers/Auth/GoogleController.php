<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
         return Socialite::driver('google')
        ->with(['prompt' => 'select_account'])
        ->redirect();
    }
   public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name'     => $googleUser->getName(),
                    'email'    => $googleUser->getEmail(),
                    'password' => bcrypt(uniqid()),
                    'is_verified' => 1,
                    'email_verified_at' => now(),
                    'status' => 'active'
                ]);
            }

            Auth::login($user);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['msg' => 'Google login failed: '.$e->getMessage()]);
        }
    }
}
