<?php
namespace App\Http\Controllers\Socialite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class ProviderRedirectController extends Controller
{
    public function __invoke(Request $request, string $provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            return redirect()->route('login')->withErrors(['provider' => 'Invalid provider']);
        }

        try {
            if ($provider === 'google') {
                return Socialite::driver($provider)
                    ->with(['prompt' => 'select_account'])
                    ->redirect();
            }

            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['provider' => 'Something went wrong']);
        }
    }
}

