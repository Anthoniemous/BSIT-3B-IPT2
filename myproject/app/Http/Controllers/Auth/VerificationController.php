<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    // Show verification notice
    public function notice()
    {
        return view('auth.verify');
    }

    // Handle verification when user clicks the link
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill(); // mark email as verified
        return redirect()->route('dashboard')->with('success', 'Email verified!');
    }

    // Resend verification link
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}
