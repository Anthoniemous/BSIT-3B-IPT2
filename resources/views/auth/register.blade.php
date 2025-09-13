<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register - Shopping Cartakada</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gradient-to-r from-green-400 via-teal-400 to-blue-500 min-h-screen flex items-center justify-center font-[Poppins]">

    <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-2xl w-full max-w-md p-8">
        
        <!-- Title -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white">📝 Create an Account</h1>
            <p class="text-gray-500 dark:text-gray-300 mt-2">Join Shopping Cartakada today!</p>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-gray-600 dark:text-gray-300">Name</label>
                <input type="text" name="name" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-600 dark:text-gray-300">Email</label>
                <input type="email" name="email" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-600 dark:text-gray-300">Password</label>
                <input type="password" name="password" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-600 dark:text-gray-300">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:text-white">
            </div>
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold transition">Register</button>
        </form>

        <!-- Back to Login -->
        <p class="mt-6 text-center text-gray-600 dark:text-gray-400 text-sm">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-500 font-semibold hover:underline">Login here</a>
        </p>
    </div>

</body>
</html>
