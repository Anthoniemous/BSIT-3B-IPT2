<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>User Dashboard - Glamour Makeup Store</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/userdashboard.css') }}">
</head>
<body>

<header class="site-header">
  <div class="container header-inner">
    <div class="logo">
      <img src="{{ asset('css/img/image.png') }}" alt="Logo">
      <span class="brand">Glamour Makeup Store 💋</span>
    </div>

    <nav class="main-nav">
      <ul>
        <a href="{{ route('user.dashboard') }}" class="nav-btn">Home</a>
      </ul>
    </nav>

    <div class="user-option">
      @auth
      <a href="{{ route('wishlist.index') }}" class="btn small">Wishlist</a>
        <a href="{{ route('orders.index') }}" class="btn small">Orders</a>
        <a href="{{ route('cart.index') }}" class="btn small">Cart 🛒</a>
      

        <div class="profile-container">
          <img 
            src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('css/img/default-avatar.png') }}" 
            alt="Profile" 
            class="profile-pic" 
            id="profileDropdownToggle"
          >
          <div class="dropdown-menu" id="profileDropdownMenu">
            <h4>Welcome back, {{ Auth::user()->name }}!</h4>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="btn small logout-btn">Logout</button>
            </form>
          </div>
        </div>
      @endauth
    </div>
  </div>
</header>

<main class="container" style="padding-top: 30px;">
<header class="section-header" style="margin-top: 40px;">
  <h2>Our Glamorous Collection</h2>
  <p class="section-sub">Indulge in your favorite beauty essentials ✨</p>
</header>

<!-- FILTER FORM -->
<div class="filter-container">
  <form method="GET" action="{{ route('user.dashboard') }}">
    <select name="category">
      <option value="">All Categories</option>
      @foreach($categories as $cat)
        <option value="{{ $cat }}" {{ $selectedCategory == $cat ? 'selected' : '' }}>{{ $cat }}</option>
      @endforeach
    </select>

    <select name="brand">
      <option value="">All Brands</option>
      @foreach($brands as $b)
        <option value="{{ $b }}" {{ $selectedBrand == $b ? 'selected' : '' }}>{{ $b }}</option>
      @endforeach
    </select>

    <input type="number" name="min_price" placeholder="Min Price" value="{{ $minPrice }}">
    <input type="number" name="max_price" placeholder="Max Price" value="{{ $maxPrice }}">

    <select name="sort">
      <option value="">Sort By</option>
      <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Newest</option>
      <option value="featured" {{ $sort == 'featured' ? 'selected' : '' }}>Featured</option>
      <option value="price_low_high" {{ $sort == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
      <option value="price_high_low" {{ $sort == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
    </select>

    <button type="submit" class="btn filter-btn">Apply</button>
  </form>
</div>

<!-- PRODUCT GRID -->
<div class="product-cards">
  @foreach($products as $product)
    <div class="product-card">

      <div class="card-media">
        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->product_name }}">
      </div>

      <div class="card-body">
        <h3>{{ $product->product_name }}</h3>
        <p class="meta"><strong>Category:</strong> {{ $product->category }}</p>
        <p class="meta"><strong>Brand:</strong> {{ $product->brand }}</p>
        <p class="price">₱{{ number_format($product->price, 2) }}</p>

        <div class="flex gap-2">
          <!-- Add to Cart -->
          <form method="POST" action="{{ route('cart.add', $product->product_id) }}">
            @csrf
            <button type="submit" class="btn add-cart">Add to Basket</button>
          </form>

          <!-- Add to Wishlist -->
          <form method="POST" action="{{ route('wishlist.add', $product->product_id) }}">
            @csrf
            <button type="submit" class="btn add-wishlist">♡ Wishlist</button>
          </form>
        </div>
      </div>
    </div>
  @endforeach
</div>

</main>

<script>
document.getElementById('profileDropdownToggle').addEventListener('click', function() {
  document.getElementById('profileDropdownMenu').classList.toggle('active');
});
window.addEventListener('click', function(e) {
  const menu = document.getElementById('profileDropdownMenu');
  const toggle = document.getElementById('profileDropdownToggle');
  if (!menu.contains(e.target) && !toggle.contains(e.target)) {
    menu.classList.remove('active');
  }
});
</script>

</body>
</html>
