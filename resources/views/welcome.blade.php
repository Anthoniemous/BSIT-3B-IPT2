<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Authentication</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-4xl bg-white shadow-2xl rounded-2xl overflow-hidden grid md:grid-cols-2">
        <!-- Left Side -->
        <div class="hidden md:flex flex-col items-center justify-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-10">
            <h1 class="text-4xl font-bold mb-4">Welcome!</h1>
            <p class="text-lg text-center">Login or create an account to explore my platform.</p>
        </div>

        <!-- Right Side (Forms) -->
        <div class="p-8">
            <div class="flex justify-center mb-6">
                <button id="loginTab" class="px-6 py-2 text-indigo-600 border-b-2 border-indigo-600 font-semibold">Login</button>
                <button id="registerTab" class="px-6 py-2 text-gray-500 hover:text-indigo-600">Register</button>
            </div>

            <!-- Login Form -->
            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">Login</button>
            </form>

            <!-- Register Form -->
            <form id="registerForm" method="POST" action="{{ route('register') }}" class="hidden">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Name</label>
                    <input type="text" name="name" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition">Register</button>
            </form>
        </div>
    </div>

    <!-- Toggle Script -->
    <script>
        const loginTab = document.getElementById("loginTab");
        const registerTab = document.getElementById("registerTab");
        const loginForm = document.getElementById("loginForm");
        const registerForm = document.getElementById("registerForm");

        loginTab.addEventListener("click", () => {
            loginForm.classList.remove("hidden");
            registerForm.classList.add("hidden");
            loginTab.classList.add("text-indigo-600", "border-b-2", "border-indigo-600");
            registerTab.classList.remove("text-indigo-600", "border-b-2", "border-indigo-600");
            registerTab.classList.add("text-gray-500");
        });

        registerTab.addEventListener("click", () => {
            registerForm.classList.remove("hidden");
            loginForm.classList.add("hidden");
            registerTab.classList.add("text-indigo-600", "border-b-2", "border-indigo-600");
            loginTab.classList.remove("text-indigo-600", "border-b-2", "border-indigo-600");
            loginTab.classList.add("text-gray-500");
        });
    </script>

</body>
</html>
