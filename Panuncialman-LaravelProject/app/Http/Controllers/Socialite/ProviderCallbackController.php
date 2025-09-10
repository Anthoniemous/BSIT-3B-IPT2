<?php

namespace App\Http\Controllers\Socialite;

use App\Models\User; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class ProviderCallbackController extends Controller
{
    public function __invoke(string $provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            return redirect()->route('login')->withErrors(['provider' => 'Invalid provider']);
        }

        $socialUser = Socialite::driver($provider)->stateless()->user();

        $username = $this->generateUsername($socialUser, $provider);

        $user = User::updateOrCreate(
            [
                'provider_id'   => $socialUser->id,
                'provider_name' => $provider,
            ],
            [
                'name'                 => $socialUser->name,
                'email'                => $socialUser->email,
                'username'             => $username,
                'email_verified_at'    => now(),
                'provider_token'       => $socialUser->token ?? null,
                'provider_refresh_token' => $socialUser->refreshToken ?? null,
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }

    private function generateUsername($socialUser, $provider)
    {
        $username = $socialUser->getNickname();

        if (!$username) {
            if (!empty($socialUser->name)) {
                $username = Str::lower(str_replace(' ', '', $socialUser->name)) . '_' . rand(1000, 9999);
            } else {
                $username = $provider . '_' . rand(1000, 9999);
            }
        }

        $username = preg_replace('/[^A-Za-z0-9]/', '', Str::lower($username));

        $baseUsername = $username;
        $count = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '_' . $count;
            $count++;
        }

        return $username;
    }
}

