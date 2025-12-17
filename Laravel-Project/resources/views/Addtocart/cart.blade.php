<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<!-- Header -->
<header class="header">
    <div class="container">
      <nav class="nav-container">
        <a href="{{ url('/') }}" class="logo">
          <i class="fas fa-basketball-ball"></i>
          <span>NBA Fan Store</span>
        </a>
        <ul class="nav-menu">
          <li><a href="{{ url('/userdashboard') }}">Shop</a></li>
          <li><a href="{{ route('orders.index') }}">Orders</a></li>
          <li><a href="{{ route('cart.index') }}">Cart</a></li>
          <li><a href="{{ route('wishlist.index') }}">Wishlist</a></li>
        </ul>
        <div class="nav-actions">
          <a href="{{ route('wishlist.index') }}" class="icon-btn">
            <i class="fas fa-bookmark"></i>
            <span class="badge">{{ Auth::user()->wishlist->count() ?? 0 }}</span>
          </a>

          <a href="{{ route('cart.index') }}" class="icon-btn">
            <i class="fas fa-shopping-cart"></i>
            <span class="badge">{{ Auth::user()->cart->count() ?? 0 }}</span>
          </a>
          
          @auth
          <div class="profile-container">
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

              @if(session('success'))
                <div class="alert alert-success">
                  <i class="fas fa-check-circle"></i>
                  {{ session('success') }}
                </div>
              @endif

              <div class="photo-upload-section">
                <h5>
                  <i class="fas fa-image"></i>
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
                      <i class="fas fa-upload"></i>
                      <span id="fileNameDisplay">Choose a photo</span>
                    </label>
                    <button type="submit" class="btn-upload" id="uploadBtn" disabled>
                      <i class="fas fa-check"></i>
                      Upload
                    </button>
                  </div>
                </form>
              </div>

              <div class="dropdown-divider"></div>

              <div class="dropdown-items">
                <a href="{{ url('/profile') }}" class="dropdown-item">
                  <i class="fas fa-user"></i>
                  My Profile
                </a>
                <a href="{{ route('orders.index') }}" class="dropdown-item">
                  <i class="fas fa-shopping-bag"></i>
                  My Orders
                </a>
                <a href="{{ url('/settings') }}" class="dropdown-item">
                  <i class="fas fa-cog"></i>
                  Settings
                </a>
              </div>

              <div class="dropdown-divider"></div>

              <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="dropdown-item logout-item">
                  <i class="fas fa-sign-out-alt"></i>
                  Logout
                </button>
              </form>
            </div>
          </div>
          @endauth
        </div>
      </nav>
    </div>
</header>

<div class="container mt-4">
    <h1 class="text-center mb-4">Cart 🛒</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-red-gradient">
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
                <tr 
                    data-cart-id="{{ $item->cart_id }}"
                    data-price="{{ $item->product->price }}"
                    data-stock="{{ $item->product->quantity }}"
                >
                    <td>
                        <input type="checkbox" class="select-item" checked>
                    </td>

                    <td>{{ $item->product->product_name }}</td>

                    <td>{{ $item->size ?? 'N/A' }}</td>

                    <td>{{ $item->product->brand }}</td>

                    <td>
                        <div class="quantity-control">
                            <button class="btn btn-sm btn-secondary"
                                onclick="changeQuantity(this,-1)">-</button>

                            <input type="text" class="quantity-input" 
                                   value="{{ $item->quantity }}" readonly>

                            <button class="btn btn-sm btn-secondary"
                                onclick="changeQuantity(this,1)"
                                {{ $item->quantity >= $item->product->quantity ? 'disabled' : '' }}>
                                +
                            </button>
                        </div>

                        <small class="text-muted">
                            Stock left: {{ $item->product->quantity }}
                        </small>
                    </td>

                    <td class="item-total">
                        ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                    </td>

                    <td>
                        <form method="POST" action="{{ route('cart.remove',$item->cart_id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Your cart is empty</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="text-end mt-3">
        <h4>Total: <span id="grand-total">₱0.00</span></h4>

        <form method="POST" action="{{ route('cart.checkout') }}">
            @csrf
            <input type="hidden" name="cart_ids" id="cart-ids">
            <button class="btn btn-success btn-lg">Checkout</button>
        </form>
    </div>
</div>

<!-- CONSOLIDATED SCRIPT - ALL IN ONE -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    // ==========================================
    // PROFILE DROPDOWN FUNCTIONALITY
    // ==========================================
    console.log("🚀 Script loaded!");
    
    const profileToggle = document.getElementById("profileDropdownToggle");
    const profileMenu = document.getElementById("profileDropdownMenu");

    console.log("Toggle element:", profileToggle);
    console.log("Menu element:", profileMenu);

    if (!profileToggle || !profileMenu) {
        console.error("❌ Profile elements not found!");
        return;
    }

    // Click to toggle dropdown
    profileToggle.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log("👆 Profile clicked!");
        profileMenu.classList.toggle("active");
        console.log("Menu active:", profileMenu.classList.contains("active"));
    });

    // Close when clicking outside
    document.addEventListener("click", function (e) {
        if (!profileMenu.contains(e.target) && !profileToggle.contains(e.target)) {
            profileMenu.classList.remove("active");
        }
    });

    // Prevent closing when clicking inside menu
    profileMenu.addEventListener("click", function (e) {
        e.stopPropagation();
    });

    // Close on ESC key
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            profileMenu.classList.remove("active");
        }
    });

    // ==========================================
    // FILE UPLOAD FUNCTIONALITY
    // ==========================================
    const photoInput = document.getElementById("profilePhotoInput");
    const fileNameDisplay = document.getElementById("fileNameDisplay");
    const uploadBtn = document.getElementById("uploadBtn");

    if (photoInput && fileNameDisplay && uploadBtn) {
        photoInput.addEventListener("change", function() {
            if (this.files && this.files[0]) {
                fileNameDisplay.textContent = this.files[0].name;
                uploadBtn.disabled = false;
                uploadBtn.classList.add("active");
            }
        });
    }

    // ==========================================
    // CART FUNCTIONALITY
    // ==========================================
    updateGrandTotal();

    // Add event listeners to select checkboxes
    document.querySelectorAll(".select-item").forEach(checkbox => {
        checkbox.addEventListener("change", updateGrandTotal);
    });
});

// ==========================================
// CART FUNCTIONS
// ==========================================
function changeQuantity(btn, delta) {
    const row = btn.closest("tr");
    const input = row.querySelector(".quantity-input");
    const stock = parseInt(row.dataset.stock);

    let qty = parseInt(input.value) + delta;
    if (qty < 1) qty = 1;
    if (qty > stock) {
        alert("Not enough stock available");
        return;
    }

    input.value = qty;

    const price = parseFloat(row.dataset.price);
    row.querySelector(".item-total").innerText =
        "₱" + (price * qty).toFixed(2);

    updateCartQuantity(row.dataset.cartId, qty);
    updateGrandTotal();
}

function updateGrandTotal() {
    let total = 0;
    let ids = [];

    document.querySelectorAll("#cart-body tr").forEach(row => {
        const checkbox = row.querySelector(".select-item");
        if (checkbox && checkbox.checked) {
            const itemTotal = row.querySelector(".item-total");
            if (itemTotal) {
                total += parseFloat(
                    itemTotal.innerText.replace("₱", "").replace(",", "")
                );
                ids.push(row.dataset.cartId);
            }
        }
    });

    const grandTotalElement = document.getElementById("grand-total");
    if (grandTotalElement) {
        grandTotalElement.innerText = "₱" + total.toFixed(2);
    }

    const cartIdsInput = document.getElementById("cart-ids");
    if (cartIdsInput) {
        cartIdsInput.value = ids.join(",");
    }
}

function updateCartQuantity(cartId, quantity) {
    fetch(`/cart/update/${cartId}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ quantity })
    });
}
</script>

</body>
</html>