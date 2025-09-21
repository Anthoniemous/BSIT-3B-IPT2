<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth; // typo fixed: Illuminte → Illuminate
use Exception;

class SocialiteController extends Controller
{
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleAuthentication()
    {

        try{

            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
            Auth::login($user);
            return redirect()->route('dashboard');
            } else {
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(str()->random(16)),
                ]);

                if($newUser) {
                Auth::login($newUser);
                return redirect()->route('dashboard');

                }

            }


        } catch(Exception $e) {
            dd($e);
        }
        
       
    }
}