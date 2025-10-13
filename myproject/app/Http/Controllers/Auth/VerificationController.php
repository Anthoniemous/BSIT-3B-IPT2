<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    // ✅ Show verification notice page
    public function notice()
    {
        return view('auth.verify');
    }

    // ✅ Resend verification link
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('customer.dashboard')
                ->with('success', 'Your email is already verified!');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent! Check your email.');
    }
}
