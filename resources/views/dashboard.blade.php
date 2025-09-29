<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-purple-700 leading-tight">
            {{ __('Online Products') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-purple-100 to-pink-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-purple-200">
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-purple-700 mb-8 text-center">Home</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Product 1 -->
                        <div class="border border-pink-200 rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 bg-gradient-to-br from-purple-50 to-pink-50">
                            <img src="https://images.unsplash.com/photo-1611003229180-8117a61e72d0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Wireless Headphones" class="w-full h-40 object-cover rounded-lg mb-4 shadow-purple-300">
                            <h3 class="text-xl font-bold text-purple-800 mb-2">Wireless Headphones</h3>
                            <p class="text-pink-600 font-semibold text-lg mb-4">$29.99</p>
                            <button class="w-full bg-purple-600 hover:bg-pink-500 text-white py-3 px-4 rounded-lg font-bold transition-all duration-200 shadow-md hover:shadow-pink-300">Add to Cart</button>
                        </div>

                        <!-- Product 2 -->
                        <div class="border border-pink-200 rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 bg-gradient-to-br from-purple-50 to-pink-50">
                            <img src="https://images.unsplash.com/photo-1587563871167-1ee9c731a7bf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Smart Watch" class="w-full h-40 object-cover rounded-lg mb-4 shadow-purple-300">
                            <h3 class="text-xl font-bold text-purple-800 mb-2">Smart Watch</h3>
                            <p class="text-pink-600 font-semibold text-lg mb-4">$39.99</p>
                            <button class="w-full bg-purple-600 hover:bg-pink-500 text-white py-3 px-4 rounded-lg font-bold transition-all duration-200 shadow-md hover:shadow-pink-300">Add to Cart</button>
                        </div>

                        <!-- Product 3 -->
                        <div class="border border-pink-200 rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 bg-gradient-to-br from-purple-50 to-pink-50">
                            <img src="https://images.unsplash.com/photo-1618221195710-dd2dabb60b29?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Bluetooth Speaker" class="w-full h-40 object-cover rounded-lg mb-4 shadow-purple-300">
                            <h3 class="text-xl font-bold text-purple-800 mb-2">Bluetooth Speaker</h3>
                            <p class="text-pink-600 font-semibold text-lg mb-4">$49.99</p>
                            <button class="w-full bg-purple-600 hover:bg-pink-500 text-white py-3 px-4 rounded-lg font-bold transition-all duration-200 shadow-md hover:shadow-pink-300">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
