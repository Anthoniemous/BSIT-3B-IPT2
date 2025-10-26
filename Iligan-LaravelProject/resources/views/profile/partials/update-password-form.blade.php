<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div>
            <x-input-label for="current_password" :value="__('Current Password')" />
            <div class="mt-1 flex items-center border rounded-md overflow-hidden">
                <x-text-input id="current_password" name="current_password" type="password" class="flex-1 border-none rounded-none pr-10 h-10" autocomplete="current-password" />
                <button type="button" class="px-3 text-gray-500 hover:text-gray-700" onclick="togglePassword('current_password', this)">
                    <i class="fa-solid fa-eye-slash"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- New Password --}}
        <div>
            <x-input-label for="password" :value="__('New Password')" />
            <div class="mt-1 flex items-center border rounded-md overflow-hidden">
                <x-text-input id="password" name="password" type="password" class="flex-1 border-none rounded-none pr-10 h-10" autocomplete="new-password" />
                <button type="button" class="px-3 text-gray-500 hover:text-gray-700" onclick="togglePassword('password', this)">
                    <i class="fa-solid fa-eye-slash"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="mt-1 flex items-center border rounded-md overflow-hidden">
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="flex-1 border-none rounded-none pr-10 h-10" autocomplete="new-password" />
                <button type="button" class="px-3 text-gray-500 hover:text-gray-700" onclick="togglePassword('password_confirmation', this)">
                    <i class="fa-solid fa-eye-slash"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-orange-500 hover:bg-orange-600">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>
</section>
