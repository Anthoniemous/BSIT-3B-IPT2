<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shopping Cartakada</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gradient-to-r from-purple-600 via-pink-500 to-purple-400 min-h-screen flex items-center justify-center font-[Poppins]">

    <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-2xl w-full max-w-md p-8">

        <!-- Logo -->
        <div class="text-center mb-6">
        <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white">🛒</h1>
            <p class="text-gray-500 dark:text-gray-300 mt-2">Welcome back! Please login to continue.</p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-gray-600 dark:text-gray-300">Email</label>
                <input type="email" name="email" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-purple-400 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-600 dark:text-gray-300">Password</label>
                <input type="password" name="password" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-purple-400 dark:bg-gray-700 dark:text-white">
            </div>
            <button type="submit" class="w-full bg-purple-600 hover:bg-pink-600 text-white py-2 px-4 rounded-lg font-semibold transition">Login</button>
        </form>

        <!-- Divider -->
        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
            <span class="mx-4 text-gray-500 dark:text-gray-400 text-sm">or</span>
            <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
        </div>

        <!-- Google Login Button -->
        @if(Route::has('google-auth'))
        <a href="{{ route('google-auth') }}"
           class="flex items-center justify-center gap-3 w-full bg-white border border-gray-300 text-gray-700 rounded-lg py-2 px-4 hover:bg-gray-50 transition duration-200 shadow-sm">
            <!-- Google Icon SVG -->
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Continue with Google
        </a>
        @else
        <!-- Fallback if route doesn't exist -->
        <div class="text-center text-gray-500 text-sm">
            Google login not configured
        </div>
        @endif

        <!-- Register Link -->
        <p class="mt-6 text-center text-gray-600 dark:text-gray-400 text-sm">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-pink-500 font-semibold hover:underline">Create one first</a>
        </p>
    </div>

</body>
</html>
