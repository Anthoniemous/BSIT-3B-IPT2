<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
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
        @if(session('success'))
          <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            {{ session('success') }}
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

          <a href="{{ url('/orders') }}" class="dropdown-item">
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
              <path d="M12 1v6m0 6v6m6-6h-6m6 0h6m-6 0h-6"></path>
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

<div class="checkout-container">
    <h1 class="checkout-title">Payment</h1>

    {{-- Order Summary Section --}}
    <div class="checkout-card mb-4">
        <h3 class="section-title">Order Summary</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
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
                        <td>{{ $item->product->product_name }}</td>
                        <td>{{ $item->size }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₱{{ number_format($item->product->price, 2) }}</td>
                        <td>₱{{ number_format($subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Total Amount:</strong></td>
                    <td><strong>₱{{ number_format($total, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Order Form --}}
    <div class="checkout-card">
        <h3 class="section-title">Order Information</h3>
        <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
            @csrf
            
            {{-- ✅ CRITICAL: Hidden input with cart IDs --}}
            <input type="hidden" name="cart_ids" value="{{ $cartItems->pluck('cart_id')->implode(',') }}">
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="3" placeholder="Enter your delivery address" required></textarea>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" id="contact" name="contact" placeholder="09XXXXXXXXX" pattern="[0-9]{11}" required>
            </div>

            <div class="form-group">
                <label style="font-weight:bold; font-size:16px;">Payment Method</label>
                <div class="payment-options">
                    <div class="payment-btn" data-method="cod">Cash on Delivery</div>
                    <div class="payment-btn" data-method="gcash">GCash</div>
                    <div class="payment-btn" data-method="maya">Maya</div>
                    <div class="payment-btn" data-method="bank">Bank Transfer</div>
                </div>

                {{-- Hidden input for payment method --}}
                <input type="hidden" name="payment_method" id="payment_method" required>
            </div>

            <div class="form-actions">
                <a href="{{ route('cart.index') }}" class="btn cancel">Back to Cart</a>
                <button type="submit" class="btn submit">Place Order</button>
            </div>
        </form>
    </div>
</div>

<script>
// Payment method selection
document.querySelectorAll('.payment-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        // Remove active from all buttons
        document.querySelectorAll('.payment-btn').forEach(x => x.classList.remove('active'));
        
        // Add active to selected button
        this.classList.add('active');
        
        // Set hidden input value
        document.getElementById('payment_method').value = this.dataset.method;
    });
});

// Form validation before submit
document.getElementById('orderForm').addEventListener('submit', function(e) {
    const paymentMethod = document.getElementById('payment_method').value;
    
    if (!paymentMethod) {
        e.preventDefault();
        alert('Please select a payment method!');
        return false;
    }
});
</script>
</body>
</html>