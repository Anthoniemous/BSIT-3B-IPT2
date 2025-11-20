<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Dashboard - NBA Fan Store</title>

  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('css/userdashboard.css') }}">
  
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

  <main class="container" style="padding-top: 30px;">

    <header class="section-header" style="margin-top: 40px;">
      <h2>All Products</h2>
      <p class="section-sub">Browse and shop your favorites</p>
    </header>

    <form id="filterForm" action="{{ route('user.search') }}" method="GET" class="filter-bar">

    <div class="search-container">
        <input 
            type="text" 
            name="search" 
            class="search-input" 
            placeholder="Search products..." 
            value="{{ request('search') }}"
            oninput="document.getElementById('filterForm').submit();"
        >
    </div>

    <div class="filters">
        <select name="category" class="category-select" onchange="this.form.submit()">
            <option value="all">All Categories</option>
            <option value="Basketball Shoes" {{ request('category')=='Basketball Shoes' ? 'selected':'' }}>Basketball Shoes</option>
            <option value="Running Shoes" {{ request('category')=='Running Shoes' ? 'selected':'' }}>Running Shoes</option>
            <option value="Lifestyle" {{ request('category')=='Lifestyle' ? 'selected':'' }}>Lifestyle</option>
            <option value="Jerseys" {{ request('category')=='Jerseys' ? 'selected':'' }}>Jerseys</option>
            <option value="Accessories" {{ request('category')=='Accessories' ? 'selected':'' }}>Accessories</option>
        </select>

        <input type="number" name="min_price" class="price-input" placeholder="Min ₱" value="{{ request('min_price') }}" oninput="this.form.submit()">
        <input type="number" name="max_price" class="price-input" placeholder="Max ₱" value="{{ request('max_price') }}" oninput="this.form.submit()">

        <select name="sort" class="styled-select" onchange="this.form.submit()">
    <!-- Default placeholder option -->
    <option value="" disabled {{ request('sort') ? '' : 'selected' }}>Sort By</option>

    <!-- Actual options -->
    <option value="featured" {{ request('sort')=='featured' ? 'selected':'' }}>Featured</option>
    <option value="newest" {{ request('sort')=='newest' ? 'selected':'' }}>Newest</option>
    <option value="price_high_low" {{ request('sort')=='price_high_low' ? 'selected':'' }}>Price: High-Low</option>
    <option value="price_low_high" {{ request('sort')=='price_low_high' ? 'selected':'' }}>Price: Low-High</option>
</select>
    </div>
</form>


    <!-- ⭐ PRODUCT LIST -->
    <div class="product-cards">
      @forelse($products as $product)
        <div class="product-card">
          <div class="card-media">
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->product_name }}">
          </div>
          <div class="card-body">
            <h3>{{ $product->product_name }}</h3>
            <p>{{ $product->category }}</p>
            <h4>{{ $product->description }}</h4>
            <p class="price">₱{{ number_format($product->price, 2) }}</p>

            <form method="POST" action="{{ route('cart.add', $product->product_id) }}">
              @csrf
              <button type="submit" class="btn add-cart">Add to Cart</button>
            </form>
          </div>
        </div>
      @empty
        <p style="margin-top:20px;">No products found matching your search/filter.</p>
      @endforelse
    </div>

    <!-- ⭐ PAGINATION -->
    <div style="margin-top:20px;">
      {{ $products->appends(request()->query())->links() }}
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
