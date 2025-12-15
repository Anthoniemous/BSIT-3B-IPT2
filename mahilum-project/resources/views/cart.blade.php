<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Cart</title>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
      <div class="logo">
        <img src="{{ asset('css/img/logo.png') }}" alt="Shampoo Logo">
        <span class="brand">Coffee Cart</span>
      </div>

     <nav class="main-nav">
        <ul>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('/userdashboard') }}">Products</a></li>
        </ul>
      </nav>

      <div class="user-option">
        @auth
        <a href="{{ route('wishlist.index') }}" class="btn small wishlist-btn">
      Wishlist
      </a>
          <a href="{{ route('orders.index') }}" class="btn small">Coffee Orders</a>
          <a href="{{ route('cart.index') }}" class="btn small">Coffee Cart</a>

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

<div class="container">


    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <p class="no-orders">☕ Your cart is empty, coffee lover! Add some brews to get started.</p>
    @else
        <!-- CART TABLE -->
        <div class="order-table">
            <table id="cart-table">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Brew</th>
                        <th>Cups</th>
                        <th>Total</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr data-price="{{ $item->product->price }}" data-cartid="{{ $item->cart_id }}">
                        <td><input type="checkbox" class="select-item" checked></td>

                        <td>{{ $item->product->product_name ?? 'Unknown Coffee' }}</td>

                        <td>
                            <div class="qty-wrapper">
                                <button class="qty-btn minus">-</button>
                                <input type="number" class="qty-input" value="{{ $item->quantity }}" min="1">
                                <button class="qty-btn plus">+</button>
                            </div>
                        </td>

                        <td class="item-total">₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>

                        <td>
                            <div class="actions">
                                <form method="POST" action="{{ route('cart.remove', $item->cart_id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn danger">🗑️ Remove</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- GRAND TOTAL + CHECKOUT (RIGHT SIDE) -->
        <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
            <div style="text-align: right;">
                <div class="grand-total-box" style="font-size: 22px; margin-bottom: 10px;">
                     Totals: <span id="grandTotal">₱0.00</span>
                </div>

                <form id="checkoutForm" method="GET" action="{{ route('orders.checkoutPage') }}">
                    <div id="selectedItemsContainer"></div>
                    <button type="submit" class="btn primary big-checkout">☕ Checkout Items</button>
                </form>
            </div>
        </div>

    @endif

    <div class="mt-6 text-center">
        <a href="{{ route('user.dashboard') }}" class="nav-btn">← Back to Dashboard</a>
        <a href="{{ route('orders.index') }}" class="nav-btn ml-3">View My Orders</a>
    </div>
</div>

<!-- JAVASCRIPT FUNCTION -->
<script>
document.addEventListener("DOMContentLoaded", () => {

    const csrf = "{{ csrf_token() }}";

    const updateTotals = () => {
        let total = 0;
        let container = document.getElementById("selectedItemsContainer");
        container.innerHTML = "";

        document.querySelectorAll("#cart-table tbody tr").forEach(row => {
            const price = parseFloat(row.dataset.price);
            const qty = parseInt(row.querySelector(".qty-input").value);
            const checked = row.querySelector(".select-item").checked;
            const cartId = row.dataset.cartid;

            const itemTotal = price * qty;
            row.querySelector(".item-total").textContent =
                "₱" + itemTotal.toFixed(2);

            if (checked) {
                total += itemTotal;

                let input = document.createElement("input");
                input.type = "hidden";
                input.name = "selected_items[]";
                input.value = cartId;
                container.appendChild(input);
            }
        });

        document.getElementById("grandTotal").textContent =
            "₱" + total.toFixed(2);
    };

    const updateDB = (cartId, qty) => {
        fetch(`/cart/update/${cartId}`, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrf
            },
            body: JSON.stringify({ quantity: qty })
        });
    };

    document.querySelectorAll("#cart-table tbody tr").forEach(row => {
        const input = row.querySelector(".qty-input");
        const cartId = row.dataset.cartid;

        row.querySelector(".plus").onclick = () => {
            input.value++;
            updateDB(cartId, input.value);
            updateTotals();
        };

        row.querySelector(".minus").onclick = () => {
            if (input.value > 1) {
                input.value--;
                updateDB(cartId, input.value);
                updateTotals();
            }
        };
    });

    updateTotals();
});

document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("profileDropdownToggle");
    const menu = document.getElementById("profileDropdownMenu");

    toggle.addEventListener("click", function (e) {
        e.stopPropagation();
        menu.classList.toggle("active");
    });

    document.addEventListener("click", function () {
        menu.classList.remove("active");
    });
});

</script>

</body>
</html>
