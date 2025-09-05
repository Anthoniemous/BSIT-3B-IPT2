{{-- resources/views/auth/verify-email.blade.php --}}

<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen p-6 bg-gray-100">
        <!-- Card -->
        <div class="w-full max-w-md p-8 bg-white shadow-xl rounded-2xl">
            
            <!-- Logo / Branding -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('img/LOGO.png') }}" alt="Logo" class="w-16 h-16">
            </div>

            <!-- Heading -->
            <h1 class="mb-4 text-2xl font-bold text-center text-gray-800">
                Verify Your Email
            </h1>
            <p class="mb-6 text-center text-gray-600">
                Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you. 
                If you didn’t receive the email, we’ll gladly send you another.
            </p>

            <!-- Success Message -->
            @if (session('status') == 'verification-link-sent')
                <div class="p-3 mb-4 text-sm text-green-600 bg-green-100 border border-green-300 rounded-lg">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            <!-- Resend Button -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" 
                    class="w-full px-4 py-2 font-semibold text-white transition bg-blue-600 rounded-xl hover:bg-blue-700">
                    Resend Verification Email
                </button>
            </form>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" 
                    class="w-full px-4 py-2 font-semibold text-gray-800 transition bg-gray-200 rounded-xl hover:bg-gray-300">
                    Logout
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
