<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarShop Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="h-full flex flex-col">

    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-9">
            <div class="flex justify-between items-center h-16">
                <a href="{{ url('/admin') }}" class="text-2xl font-bold text-green-700 flex items-center">
                    <i class="fa fa-car mr-2"></i>CarShop Admin
                </a>

                <nav class="flex space-x-4 items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-700 flex items-center">Shop</a>
                    <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-green-700 flex items-center">Profile</a>
                    <a href="{{ route('admin.orders.index') }}" class="text-gray-700 hover:text-green-700 flex items-center">
                        <i class="fas fa-user mr-1"></i>Customer Orders
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-600 flex items-center">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                </nav>
            </div>
        </div>
    </header>

    <main class="flex-1 p-6 overflow-y-auto">
        @yield('main')
    </main>

</body>
</html>
