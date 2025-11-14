<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user is admin
        if (!Auth::user()->is_admin) {
            // If not admin, redirect to normal home page
            return redirect()->route('home')->with('error', 'You do not have admin access.');
        }

        return $next($request);
    }
}
