<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart 🛒</title>
    <link rel="stylesheet" href="css/cart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <body>
  <!-- Header Start -->
 <header class="site-header">
  <div class="header-inner">
      <div class="logo">
        <img src="{{ asset('css/img/logo.jpg') }}" alt="NBA Logo">
        <span class="brand">NBA Fan Store</span>
      </div>

      <nav class="main-nav">
        <ul>
          <li><a href="{{ url('/') }}">Home</a></li>
        </ul>
      </nav>

      <div class="user-option">
        @auth
          <a href="{{ route('orders.index') }}" class="btn small"> ORDERS</a>
          <a href="{{ route('cart.index') }}" class="btn small"> CART </a>

          <div class="profile-container">
            <img 
              src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('css/img/default-avatar.png') }}" 
              alt="Profile" 
              class="profile-pic" 
              id="profileDropdownToggle"
            >

            <div class="dropdown-menu" id="profileDropdownMenu">
              <h4>Welcome, {{ Auth::user()->name }}!</h4>

              <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="profile_photo" required>
                <button type="submit">Update Photo</button>
              </form>

              @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
              @endif

              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="margin-top: 10px; background: #dc3545;">Logout</button>
              </form>
            </div>
          </div>
        @endauth
      </div>
    </div>
  </header>
    
<div class="container mt-4">
    <h1 class="page-title text-center mb-4">Cart 🛒</h1>

    <!-- Flash Messages -->
    @if(session('success'))
        <div id="flash-success" class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div id="flash-error" class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @else
        <div id="flash-success" class="alert alert-success text-center" style="display:none;">
            Item added to cart successfully!
        </div>
        <div id="flash-error" class="alert alert-danger text-center" style="display:none;">
            Something went wrong!
        </div>
    @endif

    <!-- Cart Table -->
    <div id="cart-section">
        <div class="order-table table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="cart-body">
                    @forelse($cartItems as $item)
                        <tr data-cart-id="{{ $item->cart_id }}" data-price="{{ $item->product->price }}">
                            <td>{{ $item->product->product_name ?? 'Unknown Product' }}</td>
                            <td>
                                <div class="quantity-control">
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="changeQuantity(this, -1)">-</button>
                                    <input type="text" class="quantity-input" value="{{ $item->quantity }}" readonly>
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="changeQuantity(this, 1)">+</button>
                                </div>
                            </td>
                            <td class="item-total">₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <form method="POST" action="{{ route('cart.remove', $item->cart_id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                    <form method="GET" action="{{ route('orders.order', ['cart_id' => $item->cart_id]) }}">
                                        <button type="submit" class="btn btn-primary">Checkout</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No items in your cart.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="mt-4 text-center">
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary me-2">Back to Dashboard</a>
        <a href="{{ route('orders.index') }}" class="btn btn-success">Go to Orders</a>
    </div>
</div>

<script>
    // Flash messages auto-hide
    document.addEventListener("DOMContentLoaded", function() {
        const flashSuccess = document.getElementById("flash-success");
        const flashError = document.getElementById("flash-error");

        [flashSuccess, flashError].forEach(flash => {
            if (flash && flash.style.display !== "none") {
                setTimeout(() => {
                    flash.classList.add("fade");
                    setTimeout(() => flash.style.display = "none", 600);
                }, 3000);
            }
        });
    });

    // Quantity change function
    function changeQuantity(button, delta) {
        const row = button.closest("tr");
        const input = row.querySelector(".quantity-input");
        const totalCell = row.querySelector(".item-total");

        let quantity = parseInt(input.value);
        quantity += delta;
        if (quantity < 1) quantity = 1;
        input.value = quantity;

        const pricePerItem = parseFloat(row.dataset.price);
        totalCell.textContent = `₱${(pricePerItem * quantity).toFixed(2)}`;

        // Optional: AJAX to update backend
        updateCartQuantity(row.dataset.cartId, quantity);
    }

    // AJAX call to update backend cart quantity
    function updateCartQuantity(cartId, quantity) {
        fetch(`/cart/update/${cartId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert('Failed to update cart quantity.');
            }
        })
        .catch(err => console.error(err));
    }
</script>
</body>
</html>
