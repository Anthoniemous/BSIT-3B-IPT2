<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class IsAdmin
{
    public function handle(Request $request, Closure $next)
{
    // Check kung authenticated user ba, ug role = admin
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect()->route('login')->with('error', 'You must be an admin to access this page.');
    }

    return $next($request);
}
}
