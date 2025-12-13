<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // If not logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // If user logged in using web guard AND role = admin
        if (Auth::guard('web')->check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // If using custom admin guard (optional)
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized access.');
    }
}
