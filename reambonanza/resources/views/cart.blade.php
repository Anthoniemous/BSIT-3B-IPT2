<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Shampoo Cart 🛍️</title>
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body>

<!-- ================= HEADER ================= -->
<header class="site-header">
    <div class="container header-inner">
        <div class="logo">
            <img src="{{ asset('css/img/logo.png') }}" alt="Shampoo Logo">
            <span class="brand">Green Glow Shampoo Shop</span>
        </div>

        <nav class="main-nav">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/userdashboard') }}">Products</a></li>
            </ul>
        </nav>

        <div class="user-option">
            @auth
                <a href="{{ route('wishlist.index') }}" class="btn small">Wishlist</a>
                <a href="{{ route('orders.index') }}" class="btn small">Purchase History</a>

                <div class="profile-container">
                    <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('css/img/default-avatar.png') }}"
                         alt="Profile" class="profile-pic" id="profileDropdownToggle">

                    <div class="dropdown-menu" id="profileDropdownMenu">
                        <h4>Welcome, {{ Auth::user()->name }}!</h4>

                        <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="profile_photo" required>
                            <button type="submit">Update Photo</button>
                        </form>

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

<!-- ================= CART ================= -->
<div class="cart-container">
    <h1 style="text-align:center;">🛍️ Your Shampoo Cart</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <p style="text-align:center;">🧴 Your cart is empty! Add some shampoos to get started.</p>
    @else
        <table id="cart-table">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr data-price="{{ $item->product->price }}" data-cartid="{{ $item->cart_id }}">
                    <td><input type="checkbox" class="select-item" checked></td>
                    <td>{{ $item->product->product_name }}</td>
                    <td>
                        <div class="qty-wrapper">
                            <button class="qty-btn minus">-</button>
                            <input type="number" class="qty-input" value="{{ $item->quantity }}" min="1">
                            <button class="qty-btn plus">+</button>
                        </div>
                    </td>
                    <td class="item-total">₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.remove', $item->cart_id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn danger">🗑️</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="grand-total-box">
            Grand Total: <span id="grandTotal">₱0.00</span>
        </div>

<form id="checkoutForm" method="GET" action="{{ route('orders.checkoutPage') }}">
    <div id="selectedItemsContainer"></div> <!-- container for hidden inputs -->
    <button type="submit" class="btn primary big-checkout">🧴 Checkout Selected Items</button>
</form>

    @endif

    <div style="text-align:center; margin-top:20px;">
        <a href="{{ route('user.dashboard') }}" class="nav-btn">← Back to Dashboard</a>
        <a href="{{ route('orders.index') }}" class="nav-btn ml-3">View My Orders</a>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const updateTotals = () => {
        let grandTotal = 0;
        let selected = [];
        const selectedItemsContainer = document.getElementById("selectedItemsContainer");

        document.querySelectorAll("#cart-table tbody tr").forEach(row => {
            const price = parseFloat(row.dataset.price);
            const qty = parseInt(row.querySelector(".qty-input").value);
            const checkbox = row.querySelector(".select-item");
            const totalCell = row.querySelector(".item-total");
            const cartId = row.dataset.cartid;

            const itemTotal = price * qty;
            totalCell.textContent = "₱" + itemTotal.toFixed(2);

            if (checkbox.checked) {
                grandTotal += itemTotal;
                selected.push(cartId);
            }
        });

        document.getElementById("grandTotal").textContent = "₱" + grandTotal.toFixed(2);

        // Update hidden inputs as array
        selectedItemsContainer.innerHTML = ""; // clear old inputs
        selected.forEach(cartId => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "selected_items[]"; // <-- array
            input.value = cartId;
            selectedItemsContainer.appendChild(input);
        });
    };

    document.querySelectorAll(".qty-wrapper").forEach(wrapper => {
        const input = wrapper.querySelector(".qty-input");
        wrapper.querySelector(".plus").addEventListener("click", () => {
            input.value = parseInt(input.value)+1; updateTotals();
        });
        wrapper.querySelector(".minus").addEventListener("click", () => {
            if(input.value>1){input.value=parseInt(input.value)-1;} updateTotals();
        });
    });

    document.querySelectorAll(".qty-input, .select-item").forEach(el => el.addEventListener("change", updateTotals));

    updateTotals(); // initialize totals
});
</script>

</body>
</html>
