<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    // Step 1: Redirect customer to Google
    public function redirect()
    {
        return Socialite::driver('google')
            ->redirectUrl(config('services.google.redirect'))
            ->redirect();
    }

    // Step 2: Handle Google callback for customer
    public function callbackGoogle()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find or create customer
            $customer = DB::table('customer')
                ->where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if (!$customer) {
                $customerId = DB::table('customer')->insertGetId([
                    'name'       => $googleUser->getName(),
                    'email'      => $googleUser->getEmail(),
                    'google_id'  => $googleUser->getId(),
                    'password'   => bcrypt(Str::random(16)),
                    'created_at' => now(),
                ]);

                $customer = DB::table('customer')->where('customer_id', $customerId)->first();
            }

            // ✅ Reset session and set customer role
            session()->invalidate();
            session()->regenerate();

            session()->put('role', 'customer');
            session()->put('customer_id', $customer->customer_id);

            return redirect()->route('customer.dashboard')
                             ->with('success', 'Welcome back, ' . $customer->name . '!');

        } catch (\Throwable $th) {
            return redirect('/login')->with('error', 'Google sign-in failed: ' . $th->getMessage());
        }
    }
}
