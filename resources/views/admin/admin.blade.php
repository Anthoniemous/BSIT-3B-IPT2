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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="h-full flex" x-data="{ sidebarOpen: true }">

    {{-- Sidebar --}}
    <aside :class="sidebarOpen ? 'w-64' : 'w-20'" 
           class="bg-gradient-to-b from-green-800 to-green-900 text-white min-h-screen transition-all duration-300 flex flex-col shadow-2xl">
        
        {{-- Sidebar Header --}}
        <div class="p-6 flex items-center justify-between border-b border-green-700">
            <div :class="sidebarOpen ? 'block' : 'hidden'">
                <h1 class="text-2xl font-bold flex items-center">
                    <i class="fa fa-car mr-2"></i>
                    <span>CarShop</span>
                </h1>
                <p class="text-xs text-green-300 mt-1">Admin Panel</p>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="text-white hover:bg-green-700 p-2 rounded-lg transition">
                <i :class="sidebarOpen ? 'fas fa-chevron-left' : 'fas fa-chevron-right'"></i>
            </button>
        </div>
        
        {{-- Navigation Links --}}
        <nav class="mt-6 flex-1">
            <a href="{{ route('admin.index') }}" 
               class="flex items-center px-6 py-3 hover:bg-green-700 transition group {{ request()->routeIs('admin.index') ? 'bg-green-700 border-l-4 border-white' : '' }}">
                <i class="fas fa-chart-line text-xl w-6"></i>
                <span :class="sidebarOpen ? 'ml-3' : 'hidden'" class="font-medium">Dashboard</span>
                <span x-show="!sidebarOpen" class="absolute left-20 ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap">Dashboard</span>
            </a>
            
            <a href="{{ route('admin.products') }}" 
               class="flex items-center px-6 py-3 hover:bg-green-700 transition group {{ request()->routeIs('admin.products') ? 'bg-green-700 border-l-4 border-white' : '' }}">
                <i class="fas fa-box text-xl w-6"></i>
                <span :class="sidebarOpen ? 'ml-3' : 'hidden'" class="font-medium">Products</span>
                <span x-show="!sidebarOpen" class="absolute left-20 ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap">Products</span>
            </a>
            
            <a href="{{ route('admin.orders.index') }}" 
               class="flex items-center px-6 py-3 hover:bg-green-700 transition group {{ request()->routeIs('admin.orders.*') ? 'bg-green-700 border-l-4 border-white' : '' }}">
                <i class="fas fa-shopping-cart text-xl w-6"></i>
                <span :class="sidebarOpen ? 'ml-3' : 'hidden'" class="font-medium">Orders</span>
                <span x-show="!sidebarOpen" class="absolute left-20 ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap">Orders</span>
            </a>

            <!--<a href="{{ route('home') }}" 
               class="flex items-center px-6 py-3 hover:bg-green-700 transition group">
                <i class="fas fa-store text-xl w-6"></i>
                <span :class="sidebarOpen ? 'ml-3' : 'hidden'" class="font-medium">Shop</span>
                <span x-show="!sidebarOpen" class="absolute left-20 ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap">Shop</span>
            </a>-->    

               <!-- <a href="{{ route('profile.edit') }}" 
               class="flex items-center px-6 py-3 hover:bg-green-700 transition group">
                <i class="fas fa-user text-xl w-6"></i>
                <span :class="sidebarOpen ? 'ml-3' : 'hidden'" class="font-medium">Profile</span>
                <span x-show="!sidebarOpen" class="absolute left-20 ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap">Profile</span>
            </a>-->
        </nav>

        {{-- Logout Button (Bottom) --}}
        <div class="border-t border-green-700 p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="flex items-center px-6 py-3 hover:bg-red-600 transition rounded-lg w-full group">
                    <i class="fas fa-sign-out-alt text-xl w-6"></i>
                    <span :class="sidebarOpen ? 'ml-3' : 'hidden'" class="font-medium">Logout</span>
                    <span x-show="!sidebarOpen" class="absolute left-20 ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap">Logout</span>
                </button>
            </form>

            {{-- User Info --}}
            <div class="mt-4 pt-4 border-t border-green-700" :class="sidebarOpen ? 'block' : 'hidden'">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-green-300">Administrator</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main Content Area --}}
    <div class="flex-1 flex flex-col">
        
        {{-- Top Header Bar --}}
        <header class="bg-white shadow-md h-16 flex items-center justify-between px-6">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-chart-bar text-green-600 mr-2"></i>
                Admin Dashboard
            </h2>
            <p class="text-sm text-gray-500">Welcome back, <span class="font-semibold text-gray-800">{{ auth()->user()->name }}</span>!</p>
        </header>

        {{-- Main Content --}}
        <main class="flex-1 p-6 overflow-y-auto bg-gray-50">
            @yield('main')
        </main>
    </div>

</body>
</html>