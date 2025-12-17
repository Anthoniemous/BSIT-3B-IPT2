<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NBA Fan Store - Premium Basketball Gear</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/userdashboard.css') }}">
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
 
  <!-- Products -->
  <section class="products-section" id="products">
    <div class="container">
        <div class="section-header">
          <h2>All Products</h2>
          <p>Browse and shop your favorites</p>
        </div>

      <!-- Filter Bar -->
      <form id="filterForm" action="{{ route('user.search') }}" method="GET" class="filter-bar">
        <div class="search-box">
          <i class="fas fa-search"></i>
          <input 
            type="text" 
            name="search" 
            placeholder="Search products..." 
            value="{{ request('search') }}"
            oninput="document.getElementById('filterForm').submit();"
          >
        </div>
        
        <select name="category" class="filter-select" onchange="this.form.submit()">
          <option value="all">All Categories</option>
          <option value="Basketball Shoes" {{ request('category')=='Basketball Shoes' ? 'selected':'' }}>Basketball Shoes</option>
          <option value="Running Shoes" {{ request('category')=='Running Shoes' ? 'selected':'' }}>Running Shoes</option>
          <option value="Lifestyle" {{ request('category')=='Lifestyle' ? 'selected':'' }}>Lifestyle</option>
          <option value="Jerseys" {{ request('category')=='Jerseys' ? 'selected':'' }}>Jerseys</option>
          <option value="Accessories" {{ request('category')=='Accessories' ? 'selected':'' }}>Accessories</option>
        </select>
        
        <input 
          type="number" 
          name="price_min" 
          class="filter-input" 
          placeholder="Min Price" 
          value="{{ request('price_min') }}"
          oninput="this.form.submit()"
        >
        
        <input 
          type="number" 
          name="price_max" 
          class="filter-input" 
          placeholder="Max Price" 
          value="{{ request('price_max') }}"
          oninput="this.form.submit()"
        >
        
        <input 
          type="text" 
          name="brand" 
          class="filter-input" 
          placeholder="Brand..." 
          value="{{ request('brand') }}"
          oninput="this.form.submit()"
        >

        <select name="sort" class="filter-select" onchange="this.form.submit()">
          <option value="">Sort By</option>
          <option value="featured" {{ request('sort')=='featured' ? 'selected':'' }}>Featured</option>
          <option value="newest" {{ request('sort')=='newest' ? 'selected':'' }}>Newest</option>
          <option value="price_high_low" {{ request('sort')=='price_high_low' ? 'selected':'' }}>Price: High-Low</option>
          <option value="price_low_high" {{ request('sort')=='price_low_high' ? 'selected':'' }}>Price: Low-High</option>
        </select>
      </form>

      <!-- Product Grid -->
      <div class="product-grid">
        @forelse($products as $product)
          <div class="product-card">
            <div class="product-image">
              <span class="product-badge">New</span>
              <form method="POST" action="{{ route('wishlist.add', ['product' => $product->product_id]) }}" class="wishlist-form">
                @csrf

              </form>
              <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->product_name }}">
            </div>
            <div class="product-info">
              <div class="product-category">{{ $product->category }}</div>
              <h3 class="product-name">{{ $product->product_name }}</h3>
              <div class="product-brand">Brand: {{ $product->brand ?? 'N/A' }}</div>
              <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
              <div class="product-price">₱{{ number_format($product->price, 2) }}</div>

              <!-- STOCK DISPLAY -->
              <div class="product-stock">
                @if($product->quantity > 10)
                  <span style="color: #22c55e; font-weight: bold;">In Stock: {{ $product->quantity }}</span>
                @elseif($product->quantity > 0)
                  <span style="color: #f59e0b; font-weight: bold;">Low Stock: {{ $product->quantity }}</span>
                @else
                  <span style="color: #ef4444; font-weight: bold;">Out of Stock</span>
                @endif
              </div>

              <form method="POST" action="{{ route('cart.add', $product->product_id) }}" class="product-actions">
                @csrf
                <select name="size" class="size-select" required>
                  <option value="">Select Size</option>
                  <option value="36">36</option>
                  <option value="37">37</option>
                  <option value="38">38</option>
                  <option value="39">39</option>
                  <option value="40">40</option>
                  <option value="41">41</option>
                </select>
                <button type="submit" class="add-cart-btn" @if($product->quantity == 0) disabled style="background-color: #ccc; cursor: not-allowed;" @endif>
                  <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
                  <button type="button" class="wishlist-btn">
                    <i class="fas fa-list"></i> Wishlist
                  </button>
              </form>
            </div>
          </div>
        @empty
          <div class="no-products">
            <i class="fas fa-box-open"></i>
            <p>No products found matching your search/filter.</p>
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      <div class="pagination-wrapper">
        {{ $products->appends(request()->query())->links() }}
      </div>
    </div>
  </section>

  <!-- Features -->
  <section class="features">
    <div class="container">
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-shipping-fast"></i>
          </div>
          <h3>Free Shipping</h3>
          <p>On orders over ₱2,500</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-shield-alt"></i>
          </div>
          <h3>Authentic Products</h3>
          <p>100% genuine merchandise</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-undo"></i>
          </div>
          <h3>Easy Returns</h3>
          <p>30-day return policy</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-headset"></i>
          </div>
          <h3>24/7 Support</h3>
          <p>We're here to help</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-brand">
          <h3><i class="fas fa-basketball-ball"></i> NBA Fan Store</h3>
          <p>Your ultimate destination for authentic NBA merchandise. We bring you closer to the game with premium quality products.</p>
          <div class="social-links">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
        
        <div class="footer-links">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Store Locator</a></li>
            <li><a href="#">Careers</a></li>
          </ul>
        </div>
        
        <div class="footer-links">
          <h4>Customer Service</h4>
          <ul>
            <li><a href="#">Shipping Info</a></li>
            <li><a href="#">Returns</a></li>
            <li><a href="#">Size Guide</a></li>
            <li><a href="#">FAQ</a></li>
          </ul>
        </div>
        
        <div class="footer-links">
          <h4>Legal</h4>
          <ul>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Service</a></li>
            <li><a href="#">Cookie Policy</a></li>
          </ul>
        </div>
      </div>
      
      <div class="footer-bottom">
        <p>&copy; 2024 NBA Fan Store. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script>
    // Profile dropdown toggle
    const profileToggle = document.getElementById('profileDropdownToggle');
    const profileMenu = document.getElementById('profileDropdownMenu');
    const photoInput = document.getElementById('profilePhotoInput');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const uploadBtn = document.getElementById('uploadBtn');

    if (profileToggle) {
      profileToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        profileMenu.classList.toggle('active');
      });
    }

    window.addEventListener('click', function(e) {
      if (profileMenu && profileToggle) {
        if (!profileMenu.contains(e.target) && !profileToggle.contains(e.target)) {
          profileMenu.classList.remove('active');
        }
      }
    });

    if (photoInput) {
      photoInput.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
          fileNameDisplay.textContent = fileName.length > 20 
            ? fileName.substring(0, 20) + '...' 
            : fileName;
          uploadBtn.disabled = false;
          uploadBtn.classList.add('active');
        } else {
          fileNameDisplay.textContent = 'Choose a photo';
          uploadBtn.disabled = true;
          uploadBtn.classList.remove('active');
        }
      });
    }

    if (profileMenu) {
      profileMenu.addEventListener('click', function(e) {
        e.stopPropagation();
      });
    }

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && profileMenu && profileMenu.classList.contains('active')) {
        profileMenu.classList.remove('active');
      }
    });
  </script>
</body>
</html>
