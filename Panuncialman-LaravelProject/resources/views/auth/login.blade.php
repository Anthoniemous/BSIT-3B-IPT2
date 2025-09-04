<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="text-gray-700">
            @csrf

            <!-- Email -->
            <label for="email" class="text-xs font-bold text-orange-600 after:content-['*']">Email</label>     
            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                class="w-full p-2 mb-2 mt-1 border border-orange-300 outline-none focus:ring-2 focus:ring-orange-500" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500" />

            <!-- Password -->
            <label for="password" class="text-xs font-bold text-orange-600 after:content-['*']">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full p-2 mb-2 mt-1 border border-orange-300 outline-none focus:ring-2 focus:ring-orange-500" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-500" />

            <!-- Remember Me -->
            <label for="remember_me" class="inline-flex items-center mb-2">
                <input id="remember_me" type="checkbox" name="remember" 
                    class="rounded border-orange-300 text-orange-500 shadow-sm focus:ring-orange-500">
                <span class="ms-2 text-xs text-orange-600">Remember me</span>
            </label>

            <div class="forgot-signup flex justify-between">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="block text-left text-xs text-orange-500 hover:text-orange-800 mb-4">
                        Forgot Password?
                    </a>
                @endif

                <a class="text-sm text-orange-600 hover:text-orange-800 rounded-md focus:outline-none" href="{{ route('register') }}">
                    {{ __('Haven\'t signed up yet?') }}
                </a>
            </div>
            <!-- Forgot Password -->
            

            <!-- Submit -->
            <button type="submit" class="w-full rounded bg-orange-500 text-sky-50 p-2 text-center justify-center font-bold hover:bg-orange-400">
                Log In
            </button>
        </form>
</x-guest-layout>
