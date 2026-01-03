<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Admin;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   public function store(LoginRequest $request)
{
    if (Auth::guard('web')->attempt(
        $request->only('email', 'password'),
        $request->boolean('remember')
    )) {
        $request->session()->regenerate();

        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('dashboard');
        }
    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ]);
}
    /**
     * Destroy an authenticated session.
     */
   public function destroy(Request $request): RedirectResponse
{
    // Logout lang sa current guard (web)
    Auth::guard('web')->logout();


    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}
}
