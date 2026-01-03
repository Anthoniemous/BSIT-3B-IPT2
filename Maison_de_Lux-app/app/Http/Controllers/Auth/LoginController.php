<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected function authenticated(Request $request, $user)
{
    if (!$user->hasVerifiedEmail()) {
        return redirect()->route('verification.notice');
    }

    return redirect()->route('dashboard');
}

}
