<x-guest-layout>
    <div class="">
        
        <!-- Login Box -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-50 dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg" style="height: 50vh;">
            <h1 class="text-3xl font-bold text-center text-indigo-600 mb-6">WELCOME BACK</h1>
         

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-gray-200"/>
                    <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                  type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-200"/>
                    <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                  type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Remember Me and Register Link -->
                <div class="flex items-center justify-between mt-2">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700" name="remember">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</label>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __("Don't have an account?") }}
                            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors">Register</a>
                        </p>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex flex-col sm:flex-row items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="mt-3 sm:mt-0 bg-indigo-600 hover:bg-indigo-700 w-36 rounded-lg px-6 py-2 text-white font-semibold transition-all shadow-md">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
