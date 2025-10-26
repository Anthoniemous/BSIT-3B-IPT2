<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminGoogleAuthController extends Controller
{
    // ===================================================
    // Step 1: Redirect Admin to Google
    // ===================================================
    public function redirect()
    {
        return Socialite::driver('google')
            ->redirectUrl(config('services.google.admin_redirect'))
            ->redirect();
    }

    // ===================================================
    // Step 2: Handle Google Callback for Admin
    // ===================================================
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // ✅ Find or create admin by Google ID or email
            $admin = Admin::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if (!$admin) {
                $admin = Admin::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password'  => bcrypt(Str::random(16)), // Random password since Google handles login
                ]);
            } else {
                if (!$admin->google_id) {
                    $admin->update(['google_id' => $googleUser->getId()]);
                }
            }

            // ===================================================
            // ✅ FIXED SESSION LOGIC (Safe and persistent)
            // ===================================================
            session()->flush(); // Clears previous session safely
            session(['role' => 'admin', 'admin_id' => $admin->admin_id]); // Sets session values

            // ✅ Log in via guard
            Auth::guard('admin')->login($admin);

            // ✅ Redirect directly to Admin Dashboard
            return redirect()->route('admin.dashboard')
                             ->with('success', 'Welcome back, Admin!');

        } catch (\Throwable $th) {
            return redirect('/login')
                ->with('error', 'Google sign-in failed: ' . $th->getMessage());
        }
    }
}
