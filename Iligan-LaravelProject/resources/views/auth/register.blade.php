<x-guest-layout>
    @section('page-title')
        <h1 class="text-5xl font-extrabold text-white tracking-wide drop-shadow-lg mt-0 mb-0" style="font-family:Permanent Marker, cursive;">
        SHOP ME
        </h1>
    @endsection

    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="flex items-center w-full justify-center">
            <img src="{{ asset('images/cart.png') }}" alt="Cart Logo" style="width: 150px;">
            <h1 style="padding-left: 10px; font-size: 40px; font-family: 'Arial Black', sans-serif; color: #cc5500; text-shadow: 1px 2px 3px #ffffff;">
                Shoppify
            </h2>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-white"/>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-white"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white"/>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white"/>

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-white hover:text-[#cc5500] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="border border-white ms-3 !bg-[#cc5500] hover:!bg-gray-500 !focus:outline-none !focus:ring-2 !focus:ring-offset-2 focus:!ring-[#cc5500]">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
