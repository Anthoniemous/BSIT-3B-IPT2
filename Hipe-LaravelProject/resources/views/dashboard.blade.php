<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-black-900">STEP RUSH</h2>
                <p class="mt-1 text-gray-600">Discover your perfect pair from our curated selection</p>
            </div>
            <div class="flex items-center space-x-4">
                <button class="p-3 text-gray-600 transition-colors bg-white shadow-sm hover:text-red-600 rounded-xl hover:shadow-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                <button class="relative p-3 text-gray-600 transition-colors bg-white shadow-sm hover:text-red-600 rounded-xl hover:shadow-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5a1 1 0 001 1h9.1a1 1 0 001-1L17 13M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6"></path>
                    </svg>
                    <span class="absolute flex items-center justify-center w-5 h-5 text-xs text-white bg-red-600 rounded-full -top-1 -right-1">3</span>
                </button>
            </div>
        </div>
    </x-slot>

    <!-- Hero Section -->
    <div class="-mt-6 bg-red-600">
        <div class="px-4 py-20 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div class="text-white">
                    <h1 class="mb-6 text-5xl font-bold lg:text-6xl">
                        Step Into <span class="text-yellow-300">Excellence</span>
                    </h1>
                    <p class="mb-8 text-xl text-blue-100 opacity-90">
                        From athletic performance to everyday comfort, discover shoes that match your lifestyle.
                    </p>
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <button class="px-8 py-4 font-semibold text-red-600 transition-all bg-white rounded-xl hover:bg-gray-100">
                            Explore Collection
                        </button>
                        <button class="px-8 py-4 font-semibold text-white transition-all border-2 border-white rounded-xl hover:bg-white hover:text-red-600">
                            New Arrivals
                        </button>
                    </div>
                </div>
                <div class="relative">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-6">
                            <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?w=300&h=200&fit=crop" alt="Sneakers" class="transition-transform duration-500 shadow-2xl rounded-2xl hover:scale-105">
                            <img src="https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=300&h=200&fit=crop" alt="Casual Shoes" class="transition-transform duration-500 shadow-2xl rounded-2xl hover:scale-105">
                        </div>
                        <div class="mt-12 space-y-6">
                            <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=300&h=200&fit=crop" alt="Formal Shoes" class="transition-transform duration-500 shadow-2xl rounded-2xl hover:scale-105">
                            <img src="https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?w=300&h=200&fit=crop" alt="Athletic Shoes" class="transition-transform duration-500 shadow-2xl rounded-2xl hover:scale-105">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="py-16 bg-white">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <h2 class="mb-4 text-4xl font-bold text-gray-900">Shop by Category</h2>
                <p class="max-w-2xl mx-auto text-xl text-gray-600">Perfect shoes for every occasion</p>
            </div>

            <div class="grid gap-8 md:grid-cols-3">
                <div class="transition-transform duration-300 cursor-pointer group hover:scale-105">
                    <div class="relative overflow-hidden shadow-lg rounded-3xl">
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=300&fit=crop" alt="Athletic" class="object-cover w-full transition-transform duration-700 h-72 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute text-white bottom-8 left-8">
                            <h3 class="mb-2 text-3xl font-bold">Athletic</h3>
                            <p class="mb-4 text-lg opacity-90">Performance shoes for every workout</p>
                            <span class="px-4 py-2 text-sm font-semibold rounded-full bg-white/20 backdrop-blur-sm">120+ Models</span>
                        </div>
                    </div>
                </div>

                <div class="transition-transform duration-300 cursor-pointer group hover:scale-105">
                    <div class="relative overflow-hidden shadow-lg rounded-3xl">
                        <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400&h=300&fit=crop" alt="Casual" class="object-cover w-full transition-transform duration-700 h-72 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute text-white bottom-8 left-8">
                            <h3 class="mb-2 text-3xl font-bold">Casual</h3>
                            <p class="mb-4 text-lg opacity-90">Comfortable everyday footwear</p>
                            <span class="px-4 py-2 text-sm font-semibold rounded-full bg-white/20 backdrop-blur-sm">85+ Models</span>
                        </div>
                    </div>
                </div>

                <div class="transition-transform duration-300 cursor-pointer group hover:scale-105">
                    <div class="relative overflow-hidden shadow-lg rounded-3xl">
                        <img src="https://images.unsplash.com/photo-1614252369475-531eba835eb1?w=400&h=300&fit=crop" alt="Formal" class="object-cover w-full transition-transform duration-700 h-72 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute text-white bottom-8 left-8">
                            <h3 class="mb-2 text-3xl font-bold">Formal</h3>
                            <p class="mb-4 text-lg opacity-90">Elegant shoes for special occasions</p>
                            <span class="px-4 py-2 text-sm font-semibold rounded-full bg-white/20 backdrop-blur-sm">45+ Models</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="py-16 bg-gray-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="mb-2 text-4xl font-bold text-gray-900">Featured Products</h2>
                    <p class="text-xl text-gray-600">Handpicked favorites</p>
                </div>
                <button class="flex items-center font-semibold text-red-600 hover:text-red-800">
                    View All
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </button>
            </div>

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Product 1 -->
                <div class="transition-all duration-300 bg-white shadow-sm rounded-2xl hover:shadow-xl hover:-translate-y-2 group">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=300&h=200&fit=crop" alt="Air Max Pro" class="object-cover w-full h-56 transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 text-sm font-semibold text-white bg-red-500 rounded-full">-25%</span>
                        </div>
                        <button class="absolute p-2 transition-all rounded-full opacity-0 top-4 left-4 bg-white/90 group-hover:opacity-100">
                            <svg class="w-5 h-5 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-red-600">NIKE</span>
                            <div class="flex items-center text-yellow-400">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                </svg>
                                <span class="ml-1 text-sm text-gray-600">4.8</span>
                            </div>
                        </div>
                        <h3 class="mb-2 text-lg font-bold text-gray-900">Air Max Pro</h3>
                        <p class="mb-4 text-sm text-gray-600">Athletic</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-2xl font-bold text-gray-900">$149</span>
                                <span class="text-sm text-gray-500 line-through">$199</span>
                            </div>
                            <button class="px-4 py-2 text-white bg-red-600 rounded-xl hover:bg-red-700 add-to-cart">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="transition-all duration-300 bg-white shadow-sm rounded-2xl hover:shadow-xl hover:-translate-y-2 group">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?w=300&h=200&fit=crop" alt="Classic Sneaker" class="object-cover w-full h-56 transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 text-sm font-semibold text-white bg-green-500 rounded-full">New</span>
                        </div>
                        <button class="absolute p-2 transition-all rounded-full opacity-0 top-4 left-4 bg-white/90 group-hover:opacity-100">
                            <svg class="w-5 h-5 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-red-600">ADIDAS</span>
                            <div class="flex items-center text-yellow-400">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                </svg>
                                <span class="ml-1 text-sm text-gray-600">4.6</span>
                            </div>
                        </div>
                        <h3 class="mb-2 text-lg font-bold text-gray-900">Classic Sneaker</h3>
                        <p class="mb-4 text-sm text-gray-600">Casual</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-gray-900">$89</span>
                            <button class="px-4 py-2 text-white bg-red-600 rounded-xl hover:bg-red-700 add-to-cart">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="transition-all duration-300 bg-white shadow-sm rounded-2xl hover:shadow-xl hover:-translate-y-2 group">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1614252369475-531eba835eb1?w=300&h=200&fit=crop" alt="Oxford Elite" class="object-cover w-full h-56 transition-transform duration-500 group-hover:scale-105">
                        <button class="absolute p-2 transition-all rounded-full opacity-0 top-4 left-4 bg-white/90 group-hover:opacity-100">
                            <svg class="w-5 h-5 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-red-600">CLARKS</span>
                            <div class="flex items-center text-yellow-400">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                </svg>
                                <span class="ml-1 text-sm text-gray-600">4.9</span>
                            </div>
                        </div>
                        <h3 class="mb-2 text-lg font-bold text-gray-900">Oxford Elite</h3>
                        <p class="mb-4 text-sm text-gray-600">Formal</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-gray-900">$129</span>
                            <button class="px-4 py-2 text-white bg-red-600 rounded-xl hover:bg-red-700 add-to-cart">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="transition-all duration-300 bg-white shadow-sm rounded-2xl hover:shadow-xl hover:-translate-y-2 group">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?w=300&h=200&fit=crop" alt="Runner Pro" class="object-cover w-full h-56 transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 text-sm font-semibold text-white bg-red-500 rounded-full">-15%</span>
                        </div>
                        <button class="absolute p-2 transition-all rounded-full opacity-0 top-4 left-4 bg-white/90 group-hover:opacity-100">
                            <svg class="w-5 h-5 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-red-600">PUMA</span>
                            <div class="flex items-center text-yellow-400">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                </svg>
                                <span class="ml-1 text-sm text-gray-600">4.7</span>
                            </div>
                        </div>
                        <h3 class="mb-2 text-lg font-bold text-gray-900">Runner Pro</h3>
                        <p class="mb-4 text-sm text-gray-600">Athletic</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-2xl font-bold text-gray-900">$119</span>
                                <span class="text-sm text-gray-500 line-through">$139</span>
                            </div>
                            <button class="px-4 py-2 text-white bg-red-600 rounded-xl hover:bg-red-700 add-to-cart">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="py-16 bg-white">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid gap-8 text-center md:grid-cols-4">
                <div>
                    <div class="mb-2 text-4xl font-bold text-red-600">50K+</div>
                    <div class="text-gray-600">Happy Customers</div>
                </div>
                <div>
                    <div class="mb-2 text-4xl font-bold text-red-600">250+</div>
                    <div class="text-gray-600">Shoe Models</div>
                </div>
                <div>
                    <div class="mb-2 text-4xl font-bold text-red-600">25+</div>
                    <div class="text-gray-600">Premium Brands</div>
                </div>
                <div>
                    <div class="mb-2 text-4xl font-bold text-red-600">150+</div>
                    <div class="text-gray-600">Stores Worldwide</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <div class="py-16 bg-red-600">
        <div class="max-w-3xl px-6 mx-auto text-center text-white">
            <h2 class="mb-4 text-3xl font-bold md:text-4xl">Join Our Newsletter</h2>
            <p class="mb-8 text-lg text-blue-100">Get exclusive updates on new arrivals and special offers.</p>
            <form class="flex flex-col gap-4 sm:flex-row">
                <input type="email" placeholder="Enter your email" class="flex-1 px-6 py-3 text-gray-800 rounded-xl focus:outline-none" />
                <button class="px-8 py-3 font-semibold text-red-900 transition-colors bg-yellow-400 rounded-xl hover:bg-yellow-300">
                    Subscribe
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-12 text-gray-300 bg-gray-900">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid gap-8 mb-8 md:grid-cols-4">
                <div>
                    <h3 class="mb-4 text-xl font-bold text-white">STEP RUSH</h3>
                    <p class="text-sm text-gray-400">Premium footwear that blends comfort, style, and performance.</p>
                </div>
                <div>
                    <h3 class="mb-4 text-lg font-bold text-white">Shop</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Men</a></li>
                        <li><a href="#" class="hover:text-white">Women</a></li>
                        <li><a href="#" class="hover:text-white">Kids</a></li>
                        <li><a href="#" class="hover:text-white">Sale</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-4 text-lg font-bold text-white">Support</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white">FAQs</a></li>
                        <li><a href="#" class="hover:text-white">Shipping</a></li>
                        <li><a href="#" class="hover:text-white">Returns</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-4 text-lg font-bold text-white">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69a4.29 4.29 0 001.88-2.37 8.55 8.55 0 01-2.72 1.04 4.27 4.27 0 00-7.29 3.9A12.1 12.1 0 013 4.8a4.26 4.26 0 001.32 5.7 4.22 4.22 0 01-1.94-.54v.06a4.27 4.27 0 003.43 4.18c-.46.12-.94.18-1.44.18-.35 0-.69-.03-1.02-.1a4.27 4.27 0 003.98 2.96A8.56 8.56 0 012 19.54a12.06 12.06 0 006.56 1.92c7.88 0 12.2-6.53 12.2-12.2l-.01-.56A8.68 8.68 0 0022.46 6z" />
                            </svg>
                        </a>
                        <a href="#" class="hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21.75 0H2.25C1 0 0 1 0 2.25v19.5C0 23 1 24 2.25 24h19.5c1.25 0 2.25-1 2.25-2.25V2.25C24 1 23 0 21.75 0zM7.09 20.45H3.6V9h3.49v11.45zM5.34 7.47a2.02 2.02 0 110-4.04 2.02 2.02 0 010 4.04zM20.45 20.45h-3.48v-5.59c0-1.33-.02-3.05-1.86-3.05-1.87 0-2.15 1.46-2.15 2.96v5.68h-3.48V9h3.34v1.56h.05c.47-.89 1.61-1.84 3.31-1.84 3.54 0 4.19 2.33 4.19 5.36v6.37z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="pt-8 text-sm text-center text-gray-500 border-t border-gray-700">
                © 2025 STEP RUSH. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // Add to Cart functionality
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                this.innerHTML = 'Added!';
                this.classList.add('bg-green-600');
                this.classList.remove('bg-red-600');
                
                setTimeout(() => {
                    this.innerHTML = 'Add to Cart';
                    this.classList.remove('bg-green-600');
                    this.classList.add('bg-red-600');
                }, 1500);
            });
        });

        // Newsletter subscription
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            const button = this.querySelector('button');
            const email = this.querySelector('input[type="email"]').value;
            
            if (email) {
                button.innerHTML = 'Subscribed!';
                button.classList.add('bg-green-400');
                button.classList.remove('bg-yellow-400');
                
                setTimeout(() => {
                    button.innerHTML = 'Subscribe';
                    button.classList.remove('bg-green-400');
                    button.classList.add('bg-yellow-400');
                    this.querySelector('input[type="email"]').value = '';
                }, 2000);
            }
        });
    </script>

    </div>
</x-app-layout>