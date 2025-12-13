<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="site-header">
  <div class="header-inner">
      <div class="logo">
        <img src="{{ asset('css/img/logo.jpg') }}" alt="NBA Logo">
        <span class="brand">NBA Fan Store</span>
      </div>

      <nav class="main-nav">
      <ul>
        <li><a href="{{ url('/userdashboard') }}">Shop</a></li>
        <li><a href="{{ route('orders.index') }}" style="font-weight: bold;">Orders</a></li>
        <li><a href="{{ route('cart.index') }}" style="font-weight: bold;">Cart</a></li>
        <li><a href="{{ route('wishlist.index') }}" style="font-weight: bold;">Wishlist</a></li>
      </ul>
      </nav>

      <div class="user-option">
                @auth
                    <div class="profile-container">
                        <!-- Profile Picture with Status Indicator -->
                        <div class="profile-wrapper" id="profileDropdownToggle">
                            <img 
                                src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('css/img/default-avatar.png') }}" 
                                alt="{{ Auth::user()->name }}" 
                                class="profile-pic"
                            >
                            <div class="status-indicator"></div>
                        </div>

                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu" id="profileDropdownMenu">
                            <!-- User Info Header -->
                            <div class="dropdown-header">
                                <div class="user-avatar">
                                    <img 
                                        src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('css/img/default-avatar.png') }}" 
                                        alt="{{ Auth::user()->name }}"
                                    >
                                </div>
                                <div class="user-info">
                                    <h4>{{ Auth::user()->name }}</h4>
                                    <p>{{ Auth::user()->email }}</p>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <!-- Success Message -->
                            @if(session('profile_success'))
                                <div class="alert alert-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    {{ session('profile_success') }}
                                </div>
                            @endif

                            <!-- Photo Upload Section -->
                            <div class="photo-upload-section">
                                <h5>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                    Update Profile Photo
                                </h5>
                                
                                <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" id="photoUploadForm">
                                    @csrf
                                    <div class="file-input-wrapper">
                                        <input 
                                            type="file" 
                                            name="profile_photo" 
                                            id="profilePhotoInput" 
                                            accept="image/*" 
                                            required
                                            hidden
                                        >
                                        <label for="profilePhotoInput" class="file-input-label">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="17 8 12 3 7 8"></polyline>
                                                <line x1="12" y1="3" x2="12" y2="15"></line>
                                            </svg>
                                            <span id="fileNameDisplay">Choose a photo</span>
                                        </label>
                                        <button type="submit" class="btn-upload" id="uploadBtn" disabled>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            Upload
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="dropdown-divider"></div>

                            <!-- Menu Items -->
                            <div class="dropdown-items">
                                <a href="{{ url('/profile') }}" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    My Profile
                                </a>

                                <a href="{{ route('orders.index') }}" class="dropdown-item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                        <line x1="3" y1="6" x2="21" y2="6"></line>
                                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                                    </svg>
                                    My Orders
                                </a>

                                <a href="{{ url('/settings') }}" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path d="M12 1v6m0 6v6"></path>
                                        <path d="M17 7l-5 5m0 0l-5-5"></path>
                                    </svg>
                                    Settings
                                </a>
                            </div>

                            <div class="dropdown-divider"></div>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                                @csrf
                                <button type="submit" class="dropdown-item logout-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    Logout
                                </button>
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
    @endif

    <!-- Cart Table -->
    <div id="cart-section">
        <div class="order-table table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Select</th>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Brand</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="cart-body">
                    @forelse($cartItems as $item)
                        <tr data-cart-id="{{ $item->cart_id }}" data-price="{{ $item->product->price }}">
                            <td><input type="checkbox" class="select-item" checked></td>
                            <td>{{ $item->product->product_name ?? 'Unknown Product' }}</td>
                            <td>
                                @if($item->size == 'N/A' || $item->size == null)
                                    <form action="{{ route('cart.updateSize', $item->cart_id) }}" method="POST">
                                        @csrf
                                        <select name="size" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="">Select Size</option>
                                            <option value="36">36</option>
                                            <option value="37">37</option>
                                            <option value="38">38</option>
                                            <option value="39">39</option>
                                            <option value="40">40</option>
                                            <option value="41">41</option>
                                        </select>
                                    </form>
                                @else
                                    {{ $item->size }}
                                @endif
                            </td>
                            <td>{{ $item->product->brand ?? 'Unknown Brand' }}</td>
                            <td>
                                <div class="quantity-control">
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="changeQuantity(this, -1)">-</button>
                                    <input type="text" class="quantity-input" value="{{ $item->quantity }}" readonly>
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="changeQuantity(this, 1)">+</button>
                                </div>
                            </td>
                            <td class="item-total">₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.remove', $item->cart_id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No items in your cart.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Grand Total and Checkout -->
        <div class="d-flex flex-column align-items-end mt-3">
            <h4>Total Price: <span id="grand-total">₱0.00</span></h4>
           <form id="checkout-form" method="POST" action="{{ route('cart.checkout') }}">
            @csrf
            <input type="hidden" name="cart_ids" id="cart-ids" value="">
            <button type="submit" class="btn btn-success btn-lg">Checkout</button>
        </form>
        </div>
    </div>

    <div class="mt-4 text-center">
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary me-2">Back to Dashboard</a>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    updateGrandTotal();

    // Checkbox listener
    document.querySelectorAll('.select-item').forEach(cb => {
        cb.addEventListener('change', updateGrandTotal);
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
    totalCell.textContent = `₱${(pricePerItem * quantity).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2})}`;

    updateGrandTotal();
    updateCartQuantity(row.dataset.cartId, quantity);
}

// Calculate grand total based on selected items
function updateGrandTotal() {
    let grandTotal = 0;
    let selectedIds = [];

    document.querySelectorAll('#cart-body tr').forEach(row => {
        const checkbox = row.querySelector(".select-item");
        const totalCell = row.querySelector(".item-total");
        if (checkbox && checkbox.checked && totalCell) {
            const amount = parseFloat(totalCell.textContent.replace("₱","").replace(/,/g,""));
            grandTotal += amount;
            const cartId = row.dataset.cartId;
            if (cartId) { // ✅ Only add if cartId exists
                selectedIds.push(cartId);
            }
        }
    });

    document.getElementById("grand-total").textContent = "₱" + grandTotal.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
    document.getElementById("cart-ids").value = selectedIds.join(',');
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

document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("profileDropdownToggle");
    const menu = document.getElementById("profileDropdownMenu");

    if (!toggle || !menu) return;

    toggle.addEventListener("click", function (e) {
        e.stopPropagation();
        menu.classList.toggle("active");
    });

    document.addEventListener("click", function (e) {
        if (!menu.contains(e.target) && !toggle.contains(e.target)) {
            menu.classList.remove("active");
        }
    });

    menu.addEventListener("click", function (e) {
        e.stopPropagation();
    });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            menu.classList.remove("active");
        }
    });
});
</script>
</body>
</html>
