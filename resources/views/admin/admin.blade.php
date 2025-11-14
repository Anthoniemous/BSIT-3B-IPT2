<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarShop Admin</title>

    {{-- Tailwind & AlpineJS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>

    {{-- FontAwesome --}}
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="h-full flex flex-col">

    {{-- Header --}}
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-9">
            <div class="flex justify-between items-center h-16">
                
                {{-- Logo --}}
                <a href="{{ url('/') }}" class="text-2xl font-bold text-green-700 flex items-center">
                    <i class="fa fa-car mr-2"></i>CarShop Admin
                </a>

                {{-- Navigation Links --}}
                <nav class="flex space-x-4 items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-700 transition flex items-center">
                        <i class="fas fa-store mr-1"></i>Shop
                    </a>
                    <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-green-700 transition flex items-center">
                        <i class="fas fa-user mr-1"></i>Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-600 transition flex items-center">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                </nav>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-1 p-6 overflow-y-auto">
        @yield('main')
    </main>

</body>
</html>
