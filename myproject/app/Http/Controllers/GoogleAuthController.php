<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        // Force Google to always show account chooser
        return Socialite::driver('google')
           ->with(['prompt' => 'select_account consent'])
        ->redirect();
    }

public function callbackGoogle()
{
    try {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->getId())
                    ->orWhere('email', $googleUser->getEmail())
                    ->first();

        if (!$user) {
            // Determine role based on email (example)
            $role = in_array($googleUser->getEmail(), ['admin@example.com']) ? 'admin' : 'customer';

            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'role' => $role,
                'email_verified_at' => now(), // Google email considered verified
            ]);
        }

        Auth::login($user);

        // Redirect based on role
        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('customer.dashboard');

    } catch (\Throwable $th) {
        dd('Something went wrong!! ' . $th->getMessage());
    }
}

}
