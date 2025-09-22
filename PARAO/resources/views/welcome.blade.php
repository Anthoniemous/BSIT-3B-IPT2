<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    @vite('resources/css/app.css')
</head>
<body class="antialiased bg-gray-50 text-gray-900">

    <!-- Navbar -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto flex justify-between items-center py-4 px-6">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <x-application-logo class="w-8 h-16" />
                <span class="text-xl font-bold text-gray-800">My Shop</span>
            </div>

            <!-- Auth Links -->
            <div class="space-x-4">
                <a href="{{ route('login') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                   Login
                </a>
                <a href="{{ route('register') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow hover:bg-gray-300">
                   Register
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="text-center py-24 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 text-white">
        <h1 class="text-5xl font-extrabold">Welcome to My Shop</h1>
        <p class="mt-6 text-lg max-w-2xl mx-auto">
            A simple and reliable place to connect, explore, and experience seamless shopping.
        </p>
        <div class="mt-8 space-x-4">
            <a href="{{ route('register') }}"
               class="px-6 py-3 bg-white text-blue-700 font-semibold rounded-lg shadow hover:bg-gray-100">
               Get Started
            </a>
        </div>
    </section>

    <!-- Simple Promo Section -->
    <section class="max-w-5xl mx-auto px-6 py-20 text-center space-y-12">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Fast. Simple. Reliable.</h2>
            <p class="mt-3 text-gray-600">
                We built this website to make your journey smooth and enjoyable.
            </p>
        </div>

        <div>
            <h2 class="text-3xl font-bold text-gray-800">A Place Just for You</h2>
            <p class="mt-3 text-gray-600">
                Whether you’re here to browse, connect, or explore — we’ve got you covered.
            </p>
        </div>

        <div>
            <h2 class="text-3xl font-bold text-gray-800">Join Our Community</h2>
            <p class="mt-3 text-gray-600">
                Sign up today and be part of something simple, yet meaningful.
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t text-center py-6 text-gray-600">
        &copy; {{ date('Y') }} My Shop. All rights reserved.
    </footer>

</body>
</html>
