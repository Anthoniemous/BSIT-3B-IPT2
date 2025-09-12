<x-guest-layout>
    <div class="">
        <!-- Centered Form Box -->
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-center text-indigo-600 mb-6">CREATE ACCOUNT</h1>
          

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" class="text-gray-700 dark:text-gray-200"/>
                    <x-text-input id="name" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                  type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-gray-200"/>
                    <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                  type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-200"/>
                    <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                  type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 dark:text-gray-200"/>
                    <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                  type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Submit + Already Registered -->
                <div class="flex flex-col sm:flex-row items-center justify-between mt-4">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Already registered?</a>

                    <!-- ✅ Updated Register Button -->
                    <x-primary-button class="mt-3 sm:mt-0 bg-indigo-600 hover:bg-indigo-700 w-36 rounded-lg px-6 py-2 text-white font-semibold transition-all shadow-md">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
