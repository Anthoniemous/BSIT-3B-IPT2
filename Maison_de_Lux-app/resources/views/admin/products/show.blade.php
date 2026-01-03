<x-app-layout>
        <link rel="stylesheet" href="{{ asset('assets/css/product-show.css') }}">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ $product->product_name }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p><strong>ID:</strong> {{ $product->product_id }}</p>
                            <p><strong>Brand:</strong> {{ $product->brand }}</p>
                            <p><strong>Category:</strong> {{ $product->category }}</p>
                            <p><strong>Price:</strong> ₱{{ number_format($product->price, 2) }}</p>
                            <p><strong>Stock Quantity:</strong> {{ $product->stock_quantity }}</p>
                        </div>
                        <div>
                            <p><strong>Description:</strong></p>
                            <p>{{ $product->description ?: 'No description available.' }}</p>
                            <p><strong>Created by Admin:</strong> {{ $product->user->name ?? 'Unknown' }}</p>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center space-x-4">
                            <a href="{{ route('admin.products.edit', $product->product_id) }}"
                            class="bg-gradient-to-r from-mindaro via-asparagus to-fern-green
                                    hover:from-fern-green hover:to-cal-poly-green
                                    text-black font-semibold py-3 px-6 rounded-lg
                                    shadow-md border border-fern-green
                                    transition duration-300 transform hover:scale-105">
                                Edit Product
                            </a>
                            <a href="{{ route('admin.products.index') }}" 
                            class="bg-white hover:bg-gray-100 text-black font-semibold py-3 px-6 rounded-lg 
                                    border border-[#d4af37]/60 transition duration-300">
                                Back to Products
                            </a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
