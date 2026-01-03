<x-app-layout>
    <link rel="stylesheet" href="{{ asset('assets/css/wishlist.css') }}">

    <div class="wishlist-container">
        <h1 class="page-title">My Wishlist</h1>

        @if($wishlists->count() > 0)
            <div class="wishlist-grid">
                @foreach($wishlists as $wishlist)
                    <div class="wishlist-item">
                        <div class="product-image">
                            @if($wishlist->product->product_image)
                                <img src="{{ asset('storage/products/' . $wishlist->product->product_image) }}"
                                     alt="{{ $wishlist->product->product_name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1587836374828-4dbafa94cf0e?w=400"
                                     alt="Luxury Watch">
                            @endif
                        </div>
                        <div class="product-info">
                            <p class="product-brand" style="font-family: 'Cormorant Garamond', serif; font-size: 0.9rem; color: rgba(255,255,255,0.7); margin-bottom: 0.3rem; text-transform: uppercase;">{{ $wishlist->product->brand }}</p>
                            <h3 class="product-name">{{ $wishlist->product->product_name }}</h3>
                            <p class="product-price">₱{{ number_format($wishlist->product->price, 2) }}</p>

                            <div class="action-buttons">
                                <form method="POST" action="{{ route('wishlist.moveToCart', $wishlist->product->product_id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-add-to-cart">Add to Cart</button>
                                </form>

                                <form method="POST" action="{{ route('wishlist.remove', $wishlist->product->product_id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove">Remove</button>
                                </form>
                            </div>

                            <a href="{{ route('user.product.show', $wishlist->product) }}" class="btn-view-details">
                                View Details
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-wishlist">
                <p>Your wishlist is empty.</p>
                <p><a href="{{ route('shop') }}">Browse products</a> to add items to your wishlist.</p>
            </div>
        @endif
    </div>
</x-app-layout>
