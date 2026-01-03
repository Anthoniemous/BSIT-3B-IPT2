<x-app-layout>
<link rel="stylesheet" href="{{ asset('assets/css/users.css') }}">

    <div class="shop-container">
        <!-- Search and Filter Form -->
        <div class="search-filter-container" style="max-width: 1400px; margin: 0 auto 4rem; text-align: center;">
            <form method="GET" action="{{ route('shop') }}" class="search-form" style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; align-items: center;">
               <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." style="padding: 0.8rem 1.2rem; border: 1px solid rgba(212, 175, 55, 0.3); background: var(--medium-green); color: var(--white); border-radius: 5px; font-family: 'Montserrat', sans-serif; min-width: 250px;">
                <select name="category" style="padding: 0.8rem 1.2rem; border: 1px solid rgba(212, 175, 55, 0.3); background: var(--medium-green); color: var(--white); border-radius: 5px; font-family: 'Montserrat', sans-serif;">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <select name="brand" style="padding: 0.8rem 1.2rem; border: 1px solid rgba(212, 175, 55, 0.3); background: var(--medium-green); color: var(--white); border-radius: 5px; font-family: 'Montserrat', sans-serif;">
                    <option value="">All Brands</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                    @endforeach
                </select>
                <select name="sort" style="padding: 0.8rem 1.2rem; border: 1px solid rgba(212, 175, 55, 0.3); background: var(--medium-green); color: var(--white); border-radius: 5px; font-family: 'Montserrat', sans-serif;">
                    <option value="">Sort By</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High to Low</option>
                </select>
                <button type="submit" style="background: var(--gold); color: var(--dark-green); padding: 0.8rem 2rem; border: none; border-radius: 5px; font-weight: 600; cursor: pointer; font-family: 'Montserrat', sans-serif;">Search</button>
            </form>
        </div>

        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <div class="product-image">
                            @if($product->product_image)
                                <img src="{{ asset('storage/products/' . $product->product_image) }}"
                                     alt="{{ $product->product_name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1587836374828-4dbafa94cf0e?w=400" 
                                     alt="Luxury Watch">
                            @endif
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">{{ $product->product_name }}</h3>
                            <p class="product-price">₱{{ number_format($product->price, 2) }}</p>

                            <!-- Action Buttons -->
                            <div class="product-actions" style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                                <button onclick="toggleWishlist({{ $product->product_id }}, this)"
                                        class="btn-wishlist {{ $product->isInWishlist() ? 'active' : '' }}"
                                        data-product-id="{{ $product->product_id }}"
                                        style="background: {{ $product->isInWishlist() ? 'var(--gold)' : 'transparent' }}; border: 1px solid var(--gold); color: var(--gold); padding: 0.5rem; border-radius: 3px; cursor: pointer; transition: all 0.3s;">
                                    <svg class="w-4 h-4" fill="{{ $product->isInWishlist() ? 'var(--dark-green)' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>

                                <button onclick="addToCart({{ $product->product_id }})"
                                        class="btn-cart"
                                        style="background: var(--accent-green); color: var(--white); padding: 0.5rem; border: none; border-radius: 3px; cursor: pointer; transition: all 0.3s;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13v8a2 2 0 002 2h10a2 2 0 002-2v-3"></path>
                                    </svg>
                                </button>
                            </div>

                            <a href="{{ route('user.product.show', $product) }}" class="btn-view-details">
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
            <div class="no-products">
                <p>No products available at the moment. Please check back later.</p>
            </div>
        @endif
    </div>

    <script>
        function toggleWishlist(productId, buttonElement) {
            // Check if product is currently in wishlist (based on button state)
            const isInWishlist = buttonElement.classList.contains('active');

            if (isInWishlist) {
                // Remove from wishlist
                fetch('{{ route("wishlist.remove", ":productId") }}'.replace(':productId', productId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update button state
                        buttonElement.classList.remove('active');
                        buttonElement.style.background = 'transparent';
                        buttonElement.querySelector('svg').setAttribute('fill', 'none');
                        alert('Product removed from wishlist!');
                    } else {
                        alert('Failed to remove product from wishlist.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred.');
                });
            } else {
                // Add to wishlist
                fetch('{{ route("wishlist.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update button state
                        buttonElement.classList.add('active');
                        buttonElement.style.background = 'var(--gold)';
                        buttonElement.querySelector('svg').setAttribute('fill', 'var(--dark-green)');
                        alert('Product added to wishlist!');
                    } else {
                        alert('Product already in wishlist or error occurred.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred.');
                });
            }
        }

        function addToCart(productId) {
            fetch('{{ route("cart.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Product added to cart!');
                } else {
                    alert(data.message || 'Failed to add product to cart.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred.');
            });
        }
    </script>
</x-app-layout>
