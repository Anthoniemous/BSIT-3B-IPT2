<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Wishlist | Coffee ' Sodoso</title>

  <link rel="stylesheet" href="{{ asset('customer/wishlist.css') }}">
</head>
<body>

<div class="app">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="brand">
      <div class="brand-icon">☕</div>
      <div class="brand-text">
        <div class="brand-name">Coffee ' Sodoso</div>
        <div class="brand-sub">Customer Panel</div>
      </div>
    </div>

    <nav class="menu">
      <a class="menu-item" href="{{ route('customer.dashboard') }}">
        <span class="mi">🏠</span> <span>Dashboard</span>
      </a>

      <a class="menu-item" href="{{ route('cart.index') }}">
        <span class="mi">🛒</span> <span>Cart</span>
        @if(isset($cartItems) && count($cartItems) > 0)
          <span class="badge">{{ count($cartItems) }}</span>
        @endif
      </a>

      <a class="menu-item active" href="{{ route('customer.wishlist') }}">
        <span class="mi">💖</span> <span>Wishlist</span>
        @if(isset($wishlistCount) && $wishlistCount > 0)
          <span class="badge">{{ $wishlistCount }}</span>
        @endif
      </a>

      <a class="menu-item" href="{{ route('customer.purchases') }}">
        <span class="mi">📦</span> <span>My Purchases</span>
      </a>
    </nav>

    <div class="sidebar-footer">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
      </form>
    </div>
  </aside>

  <!-- MAIN -->
  <main class="main">

    <!-- TOP BAR -->
    <header class="topbar">
      <div class="top-left">
        <h1 class="page-title">Wishlist</h1>
        <p class="page-sub">Saved items you like.</p>
      </div>

      <div class="top-right">
        <div class="profile-menu">
          <button class="profile-btn">
            👤 {{ Auth::user()->name }} <span class="caret">▾</span>
          </button>
          <div class="dropdown">
            <a href="#" id="viewProfileBtn">View Profile</a>
            <a href="{{ route('customer.purchases') }}">My Purchases</a>
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
              @csrf
              <button type="submit" class="dropdown-logout">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </header>

    <div class="content">

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
      @endif

      <!-- WISHLIST GRID -->
      <section class="card-box">
        <div class="card-head">
          <h2 class="card-title">My Wishlist</h2>
          <a href="{{ route('customer.dashboard') }}" class="btn-link">← Back to Dashboard</a>
        </div>

        <div class="product-grid">
          @if($products && $products->count() > 0)
            @foreach($products as $product)
              <div class="product-card" id="product-{{ $product->id }}">

                <div class="wishlist-heart">
                  <button class="wishlist-btn" data-id="{{ $product->id }}" title="Remove/Toggle">
                    💖
                  </button>
                </div>

                <img
                  src="{{ $product->image ? asset('storage/products/'.$product->image) : 'https://via.placeholder.com/300x200.png?text=Coffee' }}"
                  alt="{{ $product->name }}">

                <div class="product-card-body">
                  <h5>{{ $product->name }}</h5>
                  <p class="product-card-price">₱ {{ number_format($product->price,2) }}</p>
                  <p class="product-card-category">Category: {{ $product->category->name ?? '-' }}</p>
                  <p class="product-card-description">{{ $product->description ?? '-' }}</p>
                </div>

                <div class="product-card-footer">
                  <div class="actions-row">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" style="flex:1; margin:0;">
                      @csrf
                      <button type="submit" class="btn-order btn-gray">Add to Cart</button>
                    </form>

                    <form action="{{ route('buy.now', $product->id) }}" method="POST" style="flex:1; margin:0;">
                      @csrf
                      <button type="submit" class="btn-order btn-blue">Buy Now</button>
                    </form>
                  </div>

                  <button class="btn-order btn-red btn-remove" data-id="{{ $product->id }}">
                    Remove from Wishlist
                  </button>
                </div>

              </div>
            @endforeach
          @else
            <p class="empty-state">No products in your wishlist.</p>
          @endif
        </div>
      </section>

    </div>
  </main>
</div>

<!-- PROFILE MODAL (same as dashboard/cart) -->
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
          class="profile-pic">

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
          <button type="button" id="editBtn" class="save-btn muted">Edit</button>
          <button type="submit" id="saveBtn" class="save-btn primary" style="display:none;">Save</button>
        </div>

      </div>
    </form>
  </div>
</div>

<script>
  // ===== Notification =====
  function showNotification(message, type='success') {
    const notif = document.createElement('div');
    notif.className = 'wishlist-notification ' + type;
    notif.textContent = message;
    document.body.appendChild(notif);
    setTimeout(() => notif.remove(), 2000);
  }

  // ===== Toggle by heart =====
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
        if (data.status === 'removed') {
          const el = document.getElementById('product-' + productId);
          if (el) el.remove();
          showNotification('Product removed from wishlist!');
        } else if (data.status === 'added') {
          showNotification('Product added to wishlist!');
        }
      });
    });
  });

  // ===== Remove button =====
  document.querySelectorAll('.btn-remove').forEach(btn => {
    btn.addEventListener('click', function() {
      const productId = this.dataset.id;
      fetch("{{ url('/wishlist/remove') }}/" + productId, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
        },
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'removed') {
          const el = document.getElementById('product-' + productId);
          if (el) el.remove();
          showNotification('Product removed from wishlist!');
        }
      });
    });
  });

  // ===== Profile modal =====
  function previewFile() {
    const file = document.getElementById('profile_image').files[0];
    const preview = document.getElementById('previewImage');
    const reader = new FileReader();
    reader.onloadend = () => preview.src = reader.result;
    if (file) reader.readAsDataURL(file);
  }

  const modal = document.getElementById('profileModal');
  const viewBtn = document.getElementById('viewProfileBtn');
  const closeBtn = document.querySelector('.close');

  if (viewBtn) viewBtn.onclick = (e) => { e.preventDefault(); modal.style.display = 'flex'; };
  if (closeBtn) closeBtn.onclick = () => modal.style.display = 'none';
  window.onclick = e => { if (e.target === modal) modal.style.display = 'none'; };

  const editBtn = document.getElementById('editBtn');
  const saveBtn = document.getElementById('saveBtn');
  const inputs = ['name', 'address', 'profile_image'];

  if (editBtn) {
    editBtn.addEventListener('click', () => {
      inputs.forEach(id => document.getElementById(id).disabled = false);
      editBtn.style.display = 'none';
      saveBtn.style.display = 'inline-block';
    });
  }
</script>

</body>
</html>
