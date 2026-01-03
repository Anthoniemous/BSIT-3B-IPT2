<x-app-layout>
    <link rel="stylesheet" href="{{ asset('assets/css/product-show.css') }}">

    <div class="py-12 luxury-bg">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success mb-4" style="background: var(--accent-green); color: var(--gold); padding: 1rem; border-radius: 0.5rem; border: 1px solid var(--gold);">
                    {!! session('success') !!}
                </div>
            @endif
            <div class="mb-6">
                <a href="{{ route('shop') }}" class="back-link">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Products
                </a>
            </div>

            <div class="product-detail-card">
                <!-- Image Section -->
                <div class="product-image-detail">
                    @if($product->product_image)
                        <img src="{{ asset('storage/products/' . $product->product_image) }}"
                             alt="{{ $product->product_name }}">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400 text-xl">No Image</span>
                        </div>
                    @endif
                </div>

                <!-- Content Section -->
                <div class="product-detail-info">
                    <h1 class="product-name-detail">{{ $product->product_name }}</h1>
                    <p class="product-category-detail">{{ $product->category }}</p>
                    <p class="product-description-detail">{{ $product->description ?: 'No description available.' }}</p>
                    <p class="product-price-detail">₱{{ number_format($product->price, 2) }}</p>
                    <p class="product-stock">Stock Quantity: {{ $product->stock_quantity }}</p>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 flex-wrap">
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="inline">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-16 px-2 py-1 text-center bg-gray-700 text-black rounded">
                            <button type="submit" class="btn-luxury ml-2">
                                Add to Cart
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13v8a2 2 0 002 2h10a2 2 0 002-2v-3"></path>
                                </svg>
                            </button>
                        </form>
                        <a href="{{ route('shop') }}" class="btn-secondary">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
