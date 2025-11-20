<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout 🧾</title>
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
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
<div class="checkout-container">
    <h1 class="checkout-title">🧾 Checkout</h1>

    <div class="checkout-card">
        <h3 class="section-title">Order Information</h3>
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="3" placeholder="Enter your delivery address" required></textarea>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" id="contact" name="contact" placeholder="09XXXXXXXXX" required>
            </div>

            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="">Select Payment Option</option>
                    <option value="cod">Cash on Delivery</option>
                    <option value="gcash">GCash</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('cart.index') }}" class="btn cancel">← Back to Cart</a>
                <button type="submit" class="btn submit">Place Order</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
