<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Green Glow Shampoo Shop - Your Dashboard</title>

  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('css/userdashboard.css') }}">
</head>

<body>
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
        <a href="{{ route('wishlist.index') }}" class="btn small wishlist-btn">
      Wishlist
      </a>
          <a href="{{ route('orders.index') }}" class="btn small">Purchase History</a>
          <a href="{{ route('cart.index') }}" class="btn small">Your Shampoo Picks</a>

       
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

    <!-- ⭐ FILTER BAR (Brand / Category / Wishlist) -->
    <form method="GET" action="{{ route('user.dashboard') }}" class="filter-bar">
      <input 
          type="text" 
          name="brand" 
          placeholder="Search brand..." 
          value="{{ request('brand') }}"
          class="filter-input"
      >

      <select name="category" class="filter-select">
          <option value="">All Categories</option>
          @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
              {{ $cat }}
            </option>
          @endforeach
      </select>

      <button type="submit" class="btn small">Filter</button>
      
    </form>

    <!-- ⭐ SECTION HEADER -->
    <header class="section-header">
      <h2>Our Signature Shampoos</h2>
      <p class="section-sub">Nourish, shine, and glow — discover your next favorite shampoo.</p>
    </header>

    <!-- ⭐ SORTING -->
    <div class="sort-container mb-4">
      <form method="GET" action="{{ route('user.dashboard') }}">
        <select name="sort" class="styled-select" onchange="this.form.submit()">
          <option value="">Featured</option>
          <option value="newest" {{ request('sort')=='newest'?'selected':'' }}>Newest</option>
          <option value="price_low_high" {{ request('sort')=='price_low_high'?'selected':'' }}>Price: Low → High</option>
          <option value="price_high_low" {{ request('sort')=='price_high_low'?'selected':'' }}>Price: High → Low</option>
        </select>
      </form>
    </div>

    <!-- ⭐ PRODUCT LIST -->
    <div class="product-cards">
      @foreach($products as $product)
        <div class="product-card">
          <div class="card-media">
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->product_name }}">
          </div>

          <div class="card-body">
            <h3>{{ $product->product_name }}</h3>
            <p><strong>Brand:</strong> {{ $product->brand ?? 'N/A' }}</p>
            <p><strong>Category:</strong> {{ $product->category ?? 'N/A' }}</p>
            <h4>{{ $product->description }}</h4>
            <p class="price">${{ number_format($product->price, 2) }}</p>

            <!-- Add to Wishlist -->
            <form method="POST" action="{{ route('wishlist.add', $product->product_id) }}">
              @csrf
              <button type="submit" class="btn wishlist-btn">Add to Wishlist</button>
            </form>

            <!-- Add to Cart -->
            <form method="POST" action="{{ route('cart.add', $product->product_id) }}">
              @csrf
              <button type="submit" class="btn add-cart">Add to Basket</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>

  </main>

  <script>
    // 🌸 Dropdown Toggle Script
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
