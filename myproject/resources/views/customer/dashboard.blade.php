<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Dashboard</title>
  <link rel="stylesheet" href="{{ asset('customer/dashboard.css') }}">
</head>
<body>

  <!-- === NAVBAR HEADER === -->
  <nav class="navbar">
    <div class="logo">Coffee ' Sodoso ☕</div>
    
    <div class="nav-links">
      <a href="#">Home</a>
      <a href="#">Menu</a>
      <a href="#">About</a>
      <a href="#">Contact</a>
    </div>

    <div class="nav-icons">
      <a href="{{ route('cart.index') }}" class="icon cart">
        🛒
        @if(isset($cartItems) && count($cartItems) > 0)
          <span class="cart-badge">{{ count($cartItems) }}</span>
        @endif
      </a>

      <!-- Wishlist Icon -->
      <a href="{{ route('customer.wishlist') }}" class="icon wishlist">
        💖
        @if(isset($wishlistCount) && $wishlistCount > 0)
          <span class="cart-badge">{{ $wishlistCount }}</span>
        @endif
      </a>

      <div class="profile-menu">
        <button class="profile-btn" style="font-size: 15px; margin-right: 20px;">
          👤 {{ Auth::user()->name }}
        </button>
        <div class="dropdown">
          <a href="#" id="viewProfileBtn">View Profile</a>
          <a href="#">My Orders</a>
          <form action="{{ route('logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </nav>

  <!-- === HEADER BAR === -->
  <div class="header-bar">
    <h1>Welcome, {{ Auth::user()->name }}!</h1>
  </div>
    
  @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
  @endif

  <!-- === SORT FORM === -->
  <form method="GET" action="{{ route('customer.dashboard') }}" class="sort-form">
    <label for="sort">Sort By:</label>
    <select name="sort" id="sort" onchange="this.form.submit()">
      <option value="">-- Select --</option>
      <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
      <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
      <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High-Low</option>
      <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low-High</option>
    </select>
  </form>

  <!-- === PRODUCT LIST === -->
  <div class="main-content">
    @if(isset($products) && $products->count() > 0)
      @foreach($products as $product)
      <div class="product-card">
        <!-- Wishlist Heart -->
        <div class="wishlist-heart">
          <button class="wishlist-btn" data-id="{{ $product->id }}">
            @if(isset($wishlistProductIds) && in_array($product->id, $wishlistProductIds))
              💖
            @else
              ❤️
            @endif
          </button>
        </div>

        <img src="{{ $product->image ? asset('storage/products/'.$product->image) : 'https://via.placeholder.com/300x200.png?text=Coffee' }}" alt="{{ $product->name }}">
        <div class="product-card-body">
          <h5>{{ $product->name }}</h5>
          <p class="product-card-price">₱ {{ number_format($product->price,2) }}</p>
          <p class="product-card-category">Category: {{ $product->category->name ?? '-' }}</p>
          <p class="product-card-description">{{ $product->description ?? '-' }}</p>
        </div>
        <div class="product-card-footer">
          <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-order">Add to Cart</button>
          </form>
        </div>
      </div>
      @endforeach
    @else
      <p class="no-products">No products found.</p>
    @endif
  </div>

  <!-- === PROFILE VIEW / EDIT MODAL === -->
  <div id="profileModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Your Profile</h2>

      <form id="editProfileForm" action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="profile-container">
          <img id="previewImage"
            src="{{ Auth::user()->profile_image 
              ? asset('storage/profile/' . Auth::user()->profile_image) 
              : 'https://via.placeholder.com/120x120.png?text=Profile' }}"
            alt="Profile"
            class="profile-pic"
            style="width:120px; height:120px; border-radius:50%; object-fit:cover;"
          >

          <div class="field-group">
            <label>Change Picture:</label>
            <input type="file" name="profile_image" id="profile_image" accept="image/*" onchange="previewFile()" disabled>
          </div>

          <div class="field-group">
            <label>Full Name:</label>
            <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" disabled>
          </div>

          <div class="field-group">
            <label>Address:</label>
            <input type="text" name="address" id="address" value="{{ Auth::user()->address ?? '' }}" disabled>
          </div>

          <div class="field-group">
            <label>Email:</label>
            <input type="email" value="{{ Auth::user()->email }}" disabled>
          </div>

          <div class="buttons">
            <button type="button" id="editBtn" class="save-btn" style="background-color:#6c757d;">Edit</button>
            <button type="submit" id="saveBtn" class="save-btn" style="display:none;">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    // === IMAGE PREVIEW ===
    function previewFile() {
      const file = document.getElementById('profile_image').files[0];
      const preview = document.getElementById('previewImage');
      const reader = new FileReader();
      reader.onloadend = () => preview.src = reader.result;
      if (file) reader.readAsDataURL(file);
    }

    // === MODAL OPEN/CLOSE ===
    const modal = document.getElementById('profileModal');
    const btn = document.getElementById('viewProfileBtn');
    const span = document.querySelector('.close');
    if (btn) btn.onclick = () => modal.style.display = 'flex';
    if (span) span.onclick = () => modal.style.display = 'none';
    window.onclick = e => { if (e.target === modal) modal.style.display = 'none'; };

    // === EDIT TOGGLE ===
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const inputs = ['name', 'address', 'profile_image'];

    editBtn.addEventListener('click', () => {
      inputs.forEach(id => document.getElementById(id).disabled = false);
      editBtn.style.display = 'none';
      saveBtn.style.display = 'inline-block';
    });

    // === Wishlist Toggle with Notification ===
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const productId = this.dataset.id;
        fetch(`/wishlist/toggle/${productId}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
          },
        })
        .then(res => res.json())
        .then(data => {
          if(data.status === 'added') {
            this.textContent = '💖'; // filled heart
            showNotification('Product added to wishlist!');
          } else {
            this.textContent = '❤️'; // empty heart
            showNotification('Product removed from wishlist!');
          }
        });
      });
    });

    // === Notification Function ===
    function showNotification(message) {
      let notif = document.createElement('div');
      notif.className = 'wishlist-notification';
      notif.textContent = message;
      notif.style.position = 'fixed';
      notif.style.top = '20px';
      notif.style.right = '20px';
      notif.style.backgroundColor = '#28a745';
      notif.style.color = '#fff';
      notif.style.padding = '10px 20px';
      notif.style.borderRadius = '5px';
      notif.style.boxShadow = '0 2px 6px rgba(0,0,0,0.2)';
      notif.style.zIndex = 9999;
      document.body.appendChild(notif);

      setTimeout(() => {
        notif.remove();
      }, 2000); // auto remove after 2 seconds
    }
  </script>

</body>
</html>
