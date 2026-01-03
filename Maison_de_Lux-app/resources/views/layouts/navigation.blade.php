<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="text-xl font-bold text-gray-800">
                        Maison de Lux
                    </a>
                </div>

                <!-- Navigation Links -->
                @if(Auth::check())
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard')" :active="Auth::user()->isAdmin() ? request()->routeIs('admin.dashboard') : request()->routeIs('dashboard')">
                        {{ __('Home') }}
                    </x-nav-link>
                </div>
                @else
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                </div>
                @endif
                <!-- Links for normal user -->
                @if(Auth::check() && Auth::user()->role === 'user')
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('shop')" :active="request()->routeIs('shop')">
                        Products
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('wishlist')" :active="request()->routeIs('wishlist')">
                        Wishlist
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('myorders')" :active="request()->routeIs('myorders')">
                        My Orders
                    </x-nav-link>
                </div>

                @endif

                @if(Auth::check() && Auth::user()->role === 'admin')
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('products.*')">
                        {{ __('Products') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.transactions.index')" :active="request()->routeIs('transactions.*')">
                        {{ __('Transactions') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.shippings.index')" :active="request()->routeIs('shippings.*')">
                        {{ __('Shippings') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.customers.index')" :active="request()->routeIs('customers.*')">
                        {{ __('Customers') }}
                    </x-nav-link>
                </div>
                @endif

            </div>
            <!-- Settings Dropdown -->
           <div class="hidden sm:flex sm:items-center sm:space-x-4 sm:ml-6">
                @if(Auth::check() && Auth::user()->role === 'user')
                <!-- Cart -->
                <x-nav-link href="{{ route('cart') }}" class="flex items-center">
                    🛒 <span class="ml-1">Cart</span>
                </x-nav-link>
                @endif

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            @if (Auth::check() && Auth::user()->image)
                                <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                    alt="Profile Photo"
                                    class="w-8 h-8 rounded-full border-2 border-[#d4af37] shadow-sm object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::check() ? Auth::user()->name : 'User') }}&background=d4af37&color=fff"
                                    alt="Avatar"
                                    class="w-8 h-8 rounded-full border-2 border-[#d4af37] shadow-sm object-cover">
                            @endif
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::check())
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            @else
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @endif
            @if(Auth::check() && Auth::user()->role === 'admin')
            <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('products.*')">
                {{ __('Products') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.transactions.index')" :active="request()->routeIs('transactions.*')">
                {{ __('Transactions') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.shippings.index')" :active="request()->routeIs('shippings.*')">
                {{ __('Shippings') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.customers.index')" :active="request()->routeIs('customers.*')">
                {{ __('Customers') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::check() ? Auth::user()->name : 'User' }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::check() ? Auth::user()->email : 'user@example.com' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
