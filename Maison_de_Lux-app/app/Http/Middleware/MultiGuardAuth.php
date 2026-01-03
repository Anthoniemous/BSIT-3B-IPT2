<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MultiGuardAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if ($guard === 'admin') {
                if (Auth::check() && Auth::user()->role === 'admin') {
                    return $next($request);
                }
            } elseif ($guard === 'web' || $guard === null) {
                if (Auth::check()) {
                    return $next($request);
                }
            } else {
                if (Auth::guard($guard)->check()) {
                    return $next($request);
                }
            }
        }

        return redirect()->route('login');
    }
}
