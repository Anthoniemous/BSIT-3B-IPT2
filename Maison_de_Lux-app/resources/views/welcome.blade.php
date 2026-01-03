<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maison de Lux</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#142C14] via-[#2D5128] to-[#537B2F] flex items-center justify-center">
    <div class="bg-white shadow-2xl rounded-2xl w-full max-w-md p-8">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-[#142C14]">Maison de Lux</h1>
            <p class="text-gray-600 mt-2">"Make Your Every Second Valuable."</p>
        </div>

        @if (Route::has('login'))
            <div class="space-y-4">
                @auth
                <!--Dashboard(Registered admin/user)-->
                    <a href="{{ url('/dashboard') }}" 
                    class="block text-center bg-gradient-to-r from-[#537B2F] via-[#6B9B37] to-[#8DA750]
                            hover:from-[#8DA750] hover:to-[#537B2F]
                            text-white font-semibold py-2.5 px-4 rounded-lg 
                            shadow-md border border-[#6B9B37]
                            transition duration-300 transform hover:scale-105">
                        Go to Home
                    </a>
                @else
                <!--Login-->
                   <a href="{{ route('login') }}" 
                            class="block text-center bg-gradient-to-r from-[#537B2F] via-[#6B9B37] to-[#8DA750] 
                                    hover:from-[#8DA750] hover:to-[#537B2F]
                                    text-white font-semibold py-2.5 px-4 rounded-lg 
                                    shadow-md border border-[#6B9B37] 
                                    transition duration-300 transform hover:scale-105">
                                Login
                            </a>
                        <div class="flex items-center w-full">
                            <hr class="flex-grow border-gray-300">
                            <span class="px-3 text-gray-500 text-sm">or</span>
                            <hr class="flex-grow border-gray-300">
                        </div>
                    @if (Route::has('register'))
                        <!-- Register -->
                            <a href="{{ route('register') }}"
                            class="block text-center bg-white text-[#537B2F] font-semibold py-2.5 px-4 rounded-lg 
                                    shadow-md border-2 border-[#6B9B37] 
                                    hover:bg-[#142C14] hover:text-[#E4EB9C]
                                    transition duration-300 transform hover:scale-105">
                                Register
                            </a>
                    @endif
                @endauth
            </div>
        @endif
        <div class="mt-8 text-center text-sm text-gray-500">
            <p class="text-gray-600 mt-2">Welcome! Please log in or register to continue.</p>
            © {{ date('Y') }} Maisonde Lux. All rights reserved.
        </div>
    </div>
</body>
</html>