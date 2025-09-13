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
<body class="antialiased bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 min-h-screen flex items-center justify-center font-[Poppins]">

    <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-2xl w-full max-w-md p-8">
        
        <!-- Logo / Title -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white">🛒 Shopping Cartkada!</h1>
            <p class="text-gray-500 dark:text-gray-300 mt-2">Welcome back! Please login to continue.</p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-gray-600 dark:text-gray-300">Email</label>
                <input type="email" name="email" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-pink-400 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-600 dark:text-gray-300">Password</label>
                <input type="password" name="password" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-pink-400 dark:bg-gray-700 dark:text-white">
            </div>
            <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white py-2 px-4 rounded-lg font-semibold transition">Login</button>
        </form>

        <!-- Register Link -->
        <p class="mt-6 text-center text-gray-600 dark:text-gray-400 text-sm">
            Don’t have an account?
            <a href="{{ route('register') }}" class="text-pink-500 font-semibold hover:underline">Create one first</a>
        </p>
    </div>

</body>
</html>
