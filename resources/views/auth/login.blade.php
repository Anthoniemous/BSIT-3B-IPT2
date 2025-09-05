<x-guest-layout>
    <div class="text-center mb-6">
        <!-- Shopping Cart Icon -->
        <svg class="w-16 h-16 mx-auto mb-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13v8a2 2 0 002 2h10a2 2 0 002-2v-3"></path>
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
        </svg>
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">E-commerce Shopping</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Login to access your personalized shopping experience</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-green-700 dark:text-green-400" />
            <x-text-input id="email" class="block mt-1 w-full border-green-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-green-700 dark:text-green-400" />
            <x-text-input id="password" class="block mt-1 w-full border-green-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-green-300 text-green-600 shadow-sm focus:ring-green-500" name="remember">
            <label for="remember_me" class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</label>
        </div>

        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
                <a class="text-sm text-green-600 hover:text-green-800 underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transform hover:scale-105 transition duration-200">
                {{ __('Log in') }}
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">Don't have an account? <a href="{{ route('register') }}" class="text-green-600 hover:text-green-800 underline">Sign up</a></p>
    </div>
</x-guest-layout>
