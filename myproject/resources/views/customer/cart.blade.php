<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart | Coffee ' Sodoso</title>
    <link rel="stylesheet" href="{{ asset('customer/cart.css') }}">
</head>
<body>

    <!-- ===== HEADER / NAVBAR ===== -->
    <header class="navbar">
        <div class="logo">
            <h2>Coffee ' Sodoso</h2>
        </div>

        <nav class="nav-links">
            <a href="{{ route('customer.dashboard') }}">Home</a>
            <a href="#">About</a>
            <a href="#">Menu</a>
            <a href="#">Contact</a>
        </nav>

        <div class="nav-icons">
            <a href="{{ route('cart.index') }}" class="icon cart">
                🛒
                @if(isset($cartItems) && count($cartItems) > 0)
                    <span class="cart-badge">{{ count($cartItems) }}</span>
                @endif
            </a>
            <div class="dropdown">
                <button class="dropbtn">
                    👤 {{ Auth::user()->name }}
                </button>
                <div class="dropdown-content">
                    <a href="#">Profile</a>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                       Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- ===== MAIN CART CONTENT ===== -->
    <main class="cart-container">
        <a href="{{ route('customer.dashboard') }}" class="btn-back">← Back to Dashboard</a>

        <h1>Your Cart</h1>

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        @if(count($cartItems) > 0)
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cartItems as $item)
                        @php 
                            $subtotal = $item->product->price * $item->quantity; 
                            $total += $subtotal; 
                        @endphp
                        <tr>
                            <td class="product-info">
                                <img class="product-img" 
                                     src="{{ $item->product->image ? asset('storage/products/'.$item->product->image) : 'https://via.placeholder.com/80' }}" 
                                     alt="{{ $item->product->name }}">
                                <span>{{ $item->product->name }}</span>
                            </td>
                            <td>₱ {{ number_format($item->product->price, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="qty-input">
                                    <button type="submit" class="btn-update">Update</button>
                                </form>
                            </td>
                            <td>₱ {{ number_format($subtotal, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-remove">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3 class="total">Total: ₱ {{ number_format($total, 2) }}</h3>
        @else
            <p class="empty-cart">Your cart is empty.</p>
        @endif
    </main>

    <!-- ===== FEATURED PRODUCTS ===== -->
    <section class="featured-products">
        <h2>Featured Coffees</h2>
        <div class="product-grid">
            @foreach($products as $product)
                <div class="product-card">
                    <img src="{{ $product->image ? asset('storage/products/'.$product->image) : 'https://via.placeholder.com/300x200.png?text=Coffee' }}" 
                         alt="{{ $product->name }}">
                    <h3>{{ $product->name }}</h3>
                    <p>₱ {{ number_format($product->price, 2) }}</p>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-quickshop">Quick Shop</button>
                    </form>
                </div>
            @endforeach
        </div>
    </section>

</body>
</html>
