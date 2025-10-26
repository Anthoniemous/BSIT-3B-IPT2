<x-guest-layout>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="flex items-center w-full justify-center">
            <img src="{{ asset('images/Logo.png') }}" alt="Cart Logo" style="width: 150px;">
            <h1 style="padding-left: 10px; font-size: 40px; font-family: 'Arial Black', sans-serif; color: #cc5500; text-shadow: 1px 2px 3px #ffffff;">
                PAWer
            </h2>
        </div>
 
        <!-- Email Address -->
        <div >
            <x-input-label for="email" :value="__('Email')" class="text-white"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white"/>

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
                <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-white hover:text-[#cc5500] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

        <x-primary-button class="border border-white ms-3 !bg-[#cc5500] hover:!bg-gray-500 !focus:outline-none !focus:ring-2 !focus:ring-offset-2 focus:!ring-[#cc5500]">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <div class="text-center my-4">
    <hr class="my-2">
    <span class="text-center font-bold text-white">Or</span>
    
    <<div class="mt-4 flex justify-center">
    <a href="{{ route('google-auth') }}"
       class="inline-flex items-center justify-center px-4 py-2 w-full border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-white bg-[#cc5500] hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#cc5500]">
        
        <!-- Google Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" 
             class="w-5 h-5 mr-2 fill-current text-white">
            <path d="M564 325.8C564 467.3 467.1 568 324 568C186.8 568 76 457.2 76 320C76 182.8 186.8 72 324 72C390.8 72 447 96.5 490.3 136.9L422.8 201.8C334.5 116.6 170.3 180.6 170.3 320C170.3 406.5 239.4 476.6 324 476.6C422.2 476.6 459 406.2 464.8 369.7L324 369.7L324 284.4L560.1 284.4C562.4 297.1 564 309.3 564 325.8z"/>
        </svg>

        <span>Login with Google</span>
    </a>
</div>
</div>
</x-guest-layout>
