<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Customer;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google OAuth page.
     */
    public function redirect()
    {
        return Socialite::driver('google')
                        ->with(['prompt' => 'select_account']) // forces account chooser
                        ->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function callbackGoogle()
    {
        try {
            // Get user info from Google
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Find customer by google_id or email
            $customer = Customer::where('google_id', $googleUser->getId())
                                ->orWhere('email', $googleUser->getEmail())
                                ->first();

            if (!$customer) {
                // Create new customer
                $customer = Customer::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password'  => bcrypt(Str::random(16)),
                ]);

                // Send email verification
                $customer->sendEmailVerificationNotification();

                return redirect('/login')->with('success',
                    'Account created! A verification email has been sent. Please verify before logging in.'
                );
            } else {
                // Update google_id if missing
                if (is_null($customer->google_id)) {
                    $customer->google_id = $googleUser->getId();
                    $customer->save();
                }
            }

            // Prevent login if email not verified
            if (!$customer->hasVerifiedEmail()) {
                $customer->sendEmailVerificationNotification();
                return redirect('/login')->with('warning',
                    'Please verify your email before logging in. A new verification link has been sent.'
                );
            }

            // ✅ Log in via the customer guard
            Auth::guard('customer')->login($customer);

            // Regenerate session
            session()->regenerate();
            session()->put('role', 'customer');
            session()->put('customer_id', $customer->customer_id);
            session()->put('customer_name', $customer->name);
            session()->put('customer_email', $customer->email);
            session()->put('customer_image', $customer->profile_image ?? 'img/default-profile.png');

            return redirect()->route('customer.dashboard')->with('success', 'Logged in successfully via Google!');
        } catch (\Throwable $th) {
            return redirect('/login')->with('error', 'Google sign-in failed: ' . $th->getMessage());
        }
    }
}
