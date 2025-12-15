<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // if not logged in -> go login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // if not admin -> block or redirect
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('customer.dashboard');
            // or: abort(403);
        }

        return $next($request);
    }
}
