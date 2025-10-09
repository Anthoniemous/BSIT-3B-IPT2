<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\Customer;
use Illuminate\Http\Request;
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

            // Find the customer by Google ID or email
            $customer = Customer::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            // Create a new customer if not found
            if (!$customer) {
                $customer = Customer::create([
                    'first_name' => $googleUser->user['given_name'] ?? explode(' ', $googleUser->getName())[0] ?? null,
                    'last_name'  => $googleUser->user['family_name'] ?? (count(explode(' ', $googleUser->getName())) > 1 ? array_pop(explode(' ', $googleUser->getName())) : ''),
                    'name'       => $googleUser->getName(), // optional
                    'email'      => $googleUser->getEmail(),
                    'google_id'  => $googleUser->getId(),
                    'password'   => bcrypt(Str::random(16)), // dummy password
                ]);
            } else {
                // Update Google ID if missing
                if (!$customer->google_id) {
                    $customer->update([
                        'google_id' => $googleUser->getId(),
                    ]);
                }
            }

            // Login the customer using the 'customer' guard
            Auth::guard('customer')->login($customer);

            return redirect()->intended('dashboard');

        } catch (\Throwable $th) {
            dd('Something went wrong: ' . $th->getMessage());
        }
    }
}
