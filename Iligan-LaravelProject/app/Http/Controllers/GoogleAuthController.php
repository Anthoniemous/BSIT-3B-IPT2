<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect() 
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback() 
    {
        try {
            $google_user = Socialite::driver('google')->user();

            // Look for existing user by google_id OR email
            $user = User::where('google_id', $google_user->getId())
                        ->orWhere('email', $google_user->getEmail())
                        ->first();

            if ($user) {
                // Update google_id if not set yet
                if (!$user->google_id) {
                    $user->google_id = $google_user->getId();
                    $user->save();
                }
            } else {
                // Create new user if no match found
                $user = User::create([
                    'name'      => $google_user->getName(),
                    'email'     => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                    'password'  => bcrypt(Str::random(24)), // dummy password
                ]);
            }

            Auth::login($user);
            return redirect()->to('/dashboard');

        } catch (\Throwable $th) {
            dd('Something went wrong! ' . $th->getMessage());
        }
    }
}
