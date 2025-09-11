<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function __construct()
    {
        // ensure user must be logged in to access these endpoints
        $this->middleware('auth');
    }

    /**
     * Verify the user's email using signed route.
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        // redirect after successful verification
        return redirect()->intended('/dashboard');
    }

    /**
     * Resend the email verification notification.
     */
    public function send(Request $request)
    {
        // if already verified, skip
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}
