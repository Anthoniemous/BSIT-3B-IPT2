<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist</title>
    <link rel="stylesheet" href="{{ asset('customer/dashboard.css') }}">
    <style>
        /* Simple notification style */
        .wishlist-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            z-index: 9999;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">Coffee ' Sodoso ☕</div>

        <div class="nav-links">
            <a href="{{ route('customer.dashboard') }}">Home</a>
            <a href="#">Menu</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
        </div>

        <div class="nav-icons">
            <a href="{{ route('cart.index') }}" class="icon cart">
                🛒
                @if(isset($cartItems) && count($cartItems) > 0)
                    <span class="cart-badge">{{ count($cartItems) }}</span>
                @endif
            </a>

            <a href="{{ route('customer.wishlist') }}" class="icon wishlist">
                💖
                @if(isset($wishlistCount) && $wishlistCount > 0)
                    <span class="cart-badge">{{ $wishlistCount }}</span>
                @endif
            </a>

            <div class="profile-menu">
                <button class="profile-btn" style="font-size: 15px; margin-right: 20px;">
                    👤 {{ Auth::user()->name }}
                </button>
                <div class="dropdown">
                    <a href="#" id="viewProfileBtn">View Profile</a>
                    <a href="#">My Orders</a>
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="header-bar">
        <h1>My Wishlist</h1>
    </div>

    <div class="main-content">
        @if($products && $products->count() > 0)
            @foreach($products as $product)
            <div class="product-card" id="product-{{ $product->id }}">
                <div class="wishlist-heart">
                    <button class="wishlist-btn" data-id="{{ $product->id }}">
                        💖
                    </button>
                </div>

                <img src="{{ $product->image ? asset('storage/products/'.$product->image) : 'https://via.placeholder.com/300x200.png?text=Coffee' }}" alt="{{ $product->name }}">
                
                <div class="product-card-body">
                    <h5>{{ $product->name }}</h5>
                    <p class="product-card-price">₱ {{ number_format($product->price,2) }}</p>
                    <p class="product-card-category">Category: {{ $product->category->name ?? '-' }}</p>
                    <p class="product-card-description">{{ $product->description ?? '-' }}</p>
                </div>

                <div class="product-card-footer" style="padding: 10px;">
                    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="flex-grow: 1; margin: 0;">
                            @csrf
                            <button type="submit" class="btn-order" 
                                style="background-color: #6c757d; width: 100%; padding: 10px; border: none; border-radius: 4px; cursor: pointer; color: #fff; font-weight: bold;">
                                Add to Cart
                            </button>
                        </form>
                        
                        <form action="{{ route('buy.now', $product->id) }}" method="POST" style="flex-grow: 1; margin: 0;">
                            @csrf
                            <button type="submit" class="btn-order" 
                                style="background-color: #007bff; width: 100%; padding: 10px; border: none; border-radius: 4px; cursor: pointer; color: #fff; font-weight: bold;">
                                Buy Now
                            </button>
                        </form>
                    </div>

                    <button class="btn-order btn-remove" data-id="{{ $product->id }}" 
                        style="background-color: #dc3545; width: 100%; padding: 10px; border: none; border-radius: 4px; cursor: pointer; color: #fff; font-weight: bold;">
                        Remove from Wishlist
                    </button>
                </div>
                </div>
            @endforeach
        @else
            <p>No products in your wishlist.</p>
        @endif
    </div>

    <script>
        // === Notification Function ===
        function showNotification(message) {
            let notif = document.createElement('div');
            notif.className = 'wishlist-notification';
            notif.textContent = message;
            document.body.appendChild(notif);

            setTimeout(() => {
                notif.remove();
            }, 2000); // auto remove after 2 seconds
        }

        // Wishlist toggle by heart
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.id;
                fetch(`/wishlist/toggle/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'removed') {
                        document.getElementById('product-' + productId).remove();
                        showNotification('Product removed from wishlist!');
                    } else if(data.status === 'added') {
                        showNotification('Product added to wishlist!'); 
                    }
                });
            });
        });

        // Remove button functionality (using the separate button)
        document.querySelectorAll('.btn-remove').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.id;
                fetch("{{ url('/wishlist/remove') }}/" + productId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'removed') {
                        document.getElementById('product-' + productId).remove();
                        showNotification('Product removed from wishlist!');
                    }
                });
            });
        });
    </script>

</body> 
</html>