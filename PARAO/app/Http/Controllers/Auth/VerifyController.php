<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class VerifyController extends Controller
{
    public function verify($code)
    {
        $user = User::where('verification_code', $code)->where('is_verified', 0)->first();

        if (!$user) {
            return redirect('/')->with('error', 'Invalid or expired verification link.');
        }

        $user->is_verified = 1;
        $user->verification_code = null;
        $user->save();

        return redirect('/')->with('success', 'Email verified successfully! You can now login.');
    }
}
