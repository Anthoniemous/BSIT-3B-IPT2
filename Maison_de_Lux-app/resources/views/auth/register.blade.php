<x-guest-layout>
    <!-- ✅ ADD: Error message from Google redirect -->
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <p class="font-semibold">{{ session('error') }}</p>
        </div>
    @endif

    <!-- ✅ ADD: Success message if naa -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            <p class="font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <!-- ✅ CHANGE: Pre-fill with Google name if available -->
            <x-text-input id="name" 
                          class="block mt-1 w-full" 
                          type="text" 
                          name="name" 
                          :value="old('name', session('google_name'))" 
                          required 
                          autofocus 
                          autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <!-- ✅ CHANGE: Pre-fill with Google email if available -->
            <x-text-input id="email" 
                          class="block mt-1 w-full" 
                          type="email" 
                          name="email" 
                          :value="old('email', session('google_email'))" 
                          required 
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            
            <!-- ✅ ADD: Helpful hint if from Google -->
            @if(session('google_email'))
                <p class="mt-1 text-sm text-blue-600">
                    💡 Register this email to use Google login next time
                </p>
            @endif
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" 
                          class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required 
                          autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" 
                          class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" 
                          required 
                          autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role Dropdown -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Register as')" />

            <select id="role" 
                    name="role" 
                    required
                    class="block w-full mt-1 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                <option value="">Select a role</option>
                <!-- ✅ CHANGE: Auto-select 'user' if from Google -->
                <option value="user" {{ old('role', session('google_email') ? 'user' : '') == 'user' ? 'selected' : '' }}>
                    Customer
                </option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                    Admin
                </option>
            </select>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>