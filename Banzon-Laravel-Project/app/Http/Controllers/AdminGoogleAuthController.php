<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminGoogleAuthController extends Controller
{
    // Step 1: Redirect Admin to Google
    public function redirect()
    {
          return Socialite::driver('google')
            ->redirectUrl(config('services.google.admin_redirect'))
            ->redirect();
    }

    // Step 2: Handle Google Callback for Admin
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find or create admin by Google ID or email
            $admin = Admin::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if (!$admin) {
                $admin = Admin::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password'  => bcrypt(Str::random(16)),
                ]);
            } else {
                if (!$admin->google_id) {
                    $admin->update([
                        'google_id' => $googleUser->getId(),
                    ]);
                }
            }

            // Log in with admin guard
            Auth::guard('admin')->login($admin);

            return redirect()->intended('/admin/dashboard');

        } catch (\Throwable $th) {
            dd('Something went wrong: ' . $th->getMessage());
        }
    }
}
