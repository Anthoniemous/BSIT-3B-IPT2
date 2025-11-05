<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css'])
    </head>

    <body class="bg-[#242424] flex flex-col items-center justify-center min-h-screen text-white">

    <form method="POST" action="{{ route('admin_login.submit') }}">
        @csrf

        <div class="flex items-center w-full justify-center">
            <h1 style="padding-bottom: 15px; font-size: 40px; font-family: 'Arial Black', sans-serif;">
                Administrator Login
            </h2> 
        </div>
 
        <!-- Email Address -->
        <div >
            <x-input-label for="email" :value="__('Email')" class="text-white"/>
            <x-text-input id="email" class="block mt-1 w-full text-black" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white"/>
            <x-text-input id="password" class="block mt-1 w-full text-black" type="password" name="password" required autocomplete="current-password" />
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
    </body>
</html>


