<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Main Dashboard - Moto Mar Shop Admin</title>

  <!-- External CSS -->
  <link rel="stylesheet" href="{{ asset('admin/main-dashboard.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<div class="top-nav">
  <h3>Moto Mar Shop Admin</h3>
  <div class="nav-links">
    <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
    <a href="{{ route('products.index') }}">🛍 Products</a>
    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
      @csrf
      <button type="submit" class="logout-btn">Logout</button>
    </form>
  </div>
</div>

<!-- Main Dashboard Content -->
<div class="main-content">
  <div class="dashboard-container">
    <h1 class="welcome-text">Welcome, {{ session('admin_name') ?? Auth::user()->name ?? 'Admin' }}!</h1>

    @if(session('success'))
      <div class="alert-success">
        {{ session('success') }}
        <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
      </div>
    @endif

    <!-- Products Overview -->
    <div class="overview-card">
      <h2>🛍 Products Overview</h2>
      <a href="{{ route('products.index') }}" class="btn-custom">Go to Product Management</a>
    </div>

    <!-- Product Grid -->
    <div class="product-grid">
      @if(isset($products) && count($products) > 0)
        @foreach($products as $product)
          <div class="product-card">
            <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}">
            <div class="product-card-body">
              <h5 class="product-card-title">{{ $product->name }}</h5>
              <p class="product-card-price">₱ {{ number_format($product->price, 2) }}</p>
              <p class="product-card-category">Category: {{ $product->category ?? '-' }}</p>
            </div>
          </div>
        @endforeach
      @else
        <p class="no-products">No products yet.</p>
      @endif
    </div>
  </div>
</div>

</body>
</html>
