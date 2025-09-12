<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Login + Forgot password -->
        <div class="flex flex-col items-center mt-6 space-y-3">
            <x-primary-button class="px-6 py-2 text-center">
                {{ __('Log in') }}
            </x-primary-button>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-center"
                href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>


        <div class="my-6">
            <div class="flex items-center justify-center">
                <hr class="flex-grow border-gray-300">
                <span class="mx-4 text-gray-500 font-semibold">OR</span>
                <hr class="flex-grow border-gray-300">
            </div>

            <div class="w-3/5 mx-auto mt-6">
                <a href="{{ route('google-auth') }}"
                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 488 512" xmlns="http://www.w3.org/2000/svg">
                        <path d="M488 261.8c0-17.8-1.6-35-4.6-51.8H250v98.1h134c-5.8 31.3-23.2 57.7-49.6 75.4l80.2 62.2c47-43.4 73.9-107.5 73.9-183.9z" fill="#4285F4"/>
                        <path d="M250 500c67.7 0 124.5-22.4 166-60.8l-80.2-62.2c-22.3 15-50.9 23.8-85.8 23.8-65.9 0-121.7-44.5-141.6-104.4H24.5v65.7C66 453.5 152.6 500 250 500z" fill="#34A853"/>
                        <path d="M108.4 296.4c-5.1-15-8-31-8-47.4s2.9-32.4 8-47.4V136H24.5C9.3 172.2 0 210.1 0 249s9.3 76.8 24.5 113h83.9v-65.6z" fill="#FBBC05"/>
                        <path d="M250 97.6c35.7 0 67.8 12.3 92.9 36.4l69.7-69.7C374.5 28.6 317.7 6 250 6 152.6 6 66 52.5 24.5 136l83.9 65.7C128.3 142.1 184.1 97.6 250 97.6z" fill="#EA4335"/>
                    </svg>
                    Continue with Google
                </a>
            </div>
        </div>

    </form>
</x-guest-layout>
