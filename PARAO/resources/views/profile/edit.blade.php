<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Profile Overview Card --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6 flex items-center gap-6">
                {{-- Profile Image --}}
                <div>
                    <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                         alt="Profile photo"
                         class="w-24 h-24 rounded-full object-cover border-2 border-indigo-500">
                </div>

                {{-- Basic Info --}}
                <div>
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ Auth::user()->name }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ Auth::user()->email }}
                    </p>
                    <p class="text-sm text-gray-500 mt-2">
                        Member since: {{ Auth::user()->created_at->format('M d, Y') }}
                    </p>
                </div>
            </div>

            {{-- Update Profile Information --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                    Update Profile Information
                </h3>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                    Change Password
                </h3>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-red-300 dark:border-red-600">
                <h3 class="text-lg font-semibold text-red-600 mb-4">
                    Delete Account
                </h3>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
