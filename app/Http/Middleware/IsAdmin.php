<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and is admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Otherwise, redirect to home or show 403
        abort(403, 'Unauthorized action.');
    }
}
