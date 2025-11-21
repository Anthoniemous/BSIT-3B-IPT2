<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Brew Haven Coffee - Your Dashboard</title>

  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('css/userdashboard.css') }}">
</head>

<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="logo">
        <img src="{{ asset('css/img/logo.png') }}" alt="Coffee Logo">
        <span class="brand">Brew Haven Coffee</span>
      </div>

      <nav class="main-nav">
        <ul></ul>
      </nav>

      <div class="user-option">
        @auth
      <a href="{{ route('orders.index') }}" class="btn small">Brew History</a>
      <a href="{{ route('cart.index') }}" class="btn small">Your Coffee Picks ☕</a>


          <!-- Profile Dropdown -->
          <div class="profile-container">
            <img 
              src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('css/img/default-avatar.png') }}" 
              alt="Profile" 
              class="profile-pic" 
              id="profileDropdownToggle"
            >

            <div class="dropdown-menu" id="profileDropdownMenu">
              <h4>Welcome back, {{ Auth::user()->name }}!</h4>
              <p class="greet-text">Good coffee, good mood. Let’s make today brew-tiful ☕</p>

              <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="profile_photo" class="upload-label">Update Your Profile Photo</label>
                <input type="file" name="profile_photo" id="profile_photo" required>
                <button type="submit" class="btn small">Upload</button>
              </form>

              @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
              @endif

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
      <h2>Our Signature Coffee Blends</h2>
      <p class="section-sub">Sip, savor, and smile — discover your next favorite brew.</p>
    </header>

    <div class="sort-container">
    <form method="GET" action="{{ route('user.dashboard') }}">
        <select name="sort" class="sort-select" onchange="this.form.submit()">
            <option value="">Sort By</option>
            <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="featured" {{ $sort == 'featured' ? 'selected' : '' }}>Featured</option>
            <option value="price_low_high" {{ $sort == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_high_low" {{ $sort == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
        </select>
    </form>
</div>

    <div class="product-cards">
      @foreach($products as $product)
        <div class="product-card">
          <div class="card-media">
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->product_name }}">
          </div>
          <div class="card-body">
            <h3>{{ $product->product_name }}</h3>
            <p class="price">₱{{ number_format($product->price, 2) }}</p>

            <form method="POST" action="{{ route('cart.add', $product->product_id) }}">
              @csrf
              <button type="submit" class="btn add-cart">Add to Cup ☕</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  </main>

  <script>
    // Profile dropdown toggle
    document.getElementById('profileDropdownToggle').addEventListener('click', function() {
      document.getElementById('profileDropdownMenu').classList.toggle('active');
    });

    // Close dropdown if clicked outside
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
