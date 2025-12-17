<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>

    <link rel="stylesheet" href="{{ asset('customer/dashboard.css') }}">
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
            <a class="menu-item active" href="{{ route('customer.dashboard') }}">
                <span class="mi">🏠</span> <span>Dashboard</span>
            </a>

            <a class="menu-item" href="{{ route('cart.index') }}">
                <span class="mi">🛒</span> <span>Cart</span>
                @if(isset($cartItems) && count($cartItems) > 0)
                    <span class="badge">{{ count($cartItems) }}</span>
                @endif
            </a>

            <a class="menu-item" href="{{ route('customer.wishlist') }}">
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
        <h1 class="page-title">Dashboard</h1>
        <p class="page-sub">Welcome back, {{ Auth::user()->name }} 👋</p>
    </div>

    <div class="top-right">
        <div class="profile-menu">

            {{-- ✅ avatar + name button --}}
            <button type="button" class="profile-btn" id="profileBtn">
                <img
                    class="avatar"
                    src="{{ Auth::user()->profile_image
                        ? asset('storage/profile/' . Auth::user()->profile_image)
                        : 'https://via.placeholder.com/40x40.png?text=U' }}"
                    alt="Profile"
                    onerror="this.onerror=null;this.src='https://via.placeholder.com/40x40.png?text=U';"
                />
                <span class="profile-name">{{ Auth::user()->name }}</span>
                <span class="caret">▾</span>
            </button>

            <div class="dropdown" id="profileDropdown">
                {{-- ✅ mini profile header inside dropdown --}}
                <div class="dropdown-profile">
                    <img
                        class="dropdown-avatar"
                        src="{{ Auth::user()->profile_image
                            ? asset('storage/profile/' . Auth::user()->profile_image)
                            : 'https://via.placeholder.com/48x48.png?text=U' }}"
                        alt="Profile"
                    />
                    <div class="dropdown-info">
                        <div class="dropdown-name">{{ Auth::user()->name }}</div>
                        <div class="dropdown-email">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="dropdown-divider"></div>

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

            <!-- ALERTS -->
            @if(session('pending'))
                <div class="alert alert-warn">{{ session('pending') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            <!-- SORT -->
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

            <!-- PRODUCTS -->
            <div class="main-content">
                @if(isset($products) && $products->count() > 0)
                    @foreach($products as $product)
                        <div class="product-card">

                            <div class="wishlist-heart">
                                <button type="button" class="wishlist-btn" data-id="{{ $product->id }}">
                                    @if(isset($wishlistProductIds) && in_array($product->id, $wishlistProductIds))
                                        💖
                                    @else
                                        ❤️
                                    @endif
                                </button>
                            </div>

                            <img
                                src="{{ $product->image
                                    ? asset('storage/products/' . $product->image)
                                    : asset('img/placeholder.png') }}"
                                alt="{{ $product->name }}"
                                onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200.png?text=Coffee';"
                                />


                            <div class="product-card-body">
                                <h5>{{ $product->name }}</h5>
                                <p class="product-card-price">₱ {{ number_format($product->price,2) }}</p>
                                <p class="product-card-category">Category: {{ $product->category->name ?? '-' }}</p>
                                <p class="product-card-description">{{ $product->description ?? '-' }}</p>
                            </div>

                            <div class="product-card-footer">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" style="flex:1; margin:0;">
                                    @csrf
                                    <button type="submit" class="btn-order btn-cart">Add to Cart</button>
                                </form>

                                <form action="{{ route('buy.now', $product->id) }}" method="POST" style="flex:1; margin:0;">
                                    @csrf
                                    <button type="submit" class="btn-order btn-buy">Buy Now</button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                @else
                    <p class="no-products">No products found.</p>
                @endif
            </div>
        </div>
    </main>
</div>

<!-- PROFILE MODAL -->
<div id="profileModal" class="modal" aria-hidden="true">
    <div class="modal-content">
        <button type="button" class="close" id="closeModalBtn">&times;</button>

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
                    <input type="file" name="profile_image" id="profile_image" accept="image/*" disabled>
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
                    <button type="button" id="editBtn" class="save-btn btn-gray">Edit</button>
                    <button type="submit" id="saveBtn" class="save-btn btn-green" style="display:none;">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
/* =========================
   Helpers: Modal
   ========================= */
function openModal(modalEl) {
  if (!modalEl) return;
  modalEl.style.display = 'flex';
  modalEl.setAttribute('aria-hidden', 'false');
  document.body.classList.add('modal-open');
}

function closeModal(modalEl) {
  if (!modalEl) return;
  modalEl.style.display = 'none';
  modalEl.setAttribute('aria-hidden', 'true');
  document.body.classList.remove('modal-open');
}

/* =========================
   Profile Dropdown
   ========================= */
const profileBtn = document.getElementById('profileBtn');
const profileDropdown = document.getElementById('profileDropdown');

if (profileBtn && profileDropdown) {
  profileBtn.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    profileDropdown.classList.toggle('open');
  });

  // close dropdown when clicking outside
  document.addEventListener('click', () => {
    profileDropdown.classList.remove('open');
  });

  // prevent closing when clicking inside dropdown
  profileDropdown.addEventListener('click', (e) => {
    e.stopPropagation();
  });
}

/* =========================
   Profile Modal
   ========================= */
const modal = document.getElementById('profileModal');
const viewProfileBtn = document.getElementById('viewProfileBtn');
const closeModalBtn = document.getElementById('closeModalBtn');

if (viewProfileBtn && modal) {
  viewProfileBtn.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    if (profileDropdown) profileDropdown.classList.remove('open');
    openModal(modal);
  });
}

if (closeModalBtn && modal) {
  closeModalBtn.addEventListener('click', (e) => {
    e.preventDefault();
    closeModal(modal);
  });
}

// close modal when clicking the dark backdrop
window.addEventListener('click', (e) => {
  if (modal && e.target === modal) closeModal(modal);
});

// close modal on ESC
window.addEventListener('keydown', (e) => {
  if (e.key === 'Escape' && modal && modal.style.display === 'flex') {
    closeModal(modal);
  }
});

/* =========================
   Edit Toggle (Enable Inputs)
   ========================= */
const editBtn = document.getElementById('editBtn');
const saveBtn = document.getElementById('saveBtn');

if (editBtn && saveBtn) {
  editBtn.addEventListener('click', (e) => {
    e.preventDefault();

    const nameInput = document.getElementById('name');
    const addressInput = document.getElementById('address');
    const fileInput = document.getElementById('profile_image');

    if (nameInput) nameInput.disabled = false;
    if (addressInput) addressInput.disabled = false;
    if (fileInput) fileInput.disabled = false;

    editBtn.style.display = 'none';
    saveBtn.style.display = 'inline-block';
  });
}

/* =========================
   Image Preview (Profile)
   ========================= */
const profileImageInput = document.getElementById('profile_image');

if (profileImageInput) {
  profileImageInput.addEventListener('change', () => {
    const file = profileImageInput.files && profileImageInput.files[0];
    const preview = document.getElementById('previewImage');

    if (!file || !preview) return;

    const reader = new FileReader();
    reader.onloadend = () => {
      preview.src = reader.result;
    };
    reader.readAsDataURL(file);
  });
}

/* =========================
   Wishlist Toggle (AJAX)
   ========================= */
document.querySelectorAll('.wishlist-btn').forEach((btn) => {
  btn.addEventListener('click', function () {
    const productId = this.dataset.id;
    if (!productId) return;

    fetch(`/wishlist/toggle/${productId}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
      },
    })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === 'added') {
        this.textContent = '💖';
        showNotification('Product added to wishlist!');
      } else {
        this.textContent = '❤️';
        showNotification('Product removed from wishlist!');
      }
    })
    .catch(() => {
      showNotification('Something went wrong. Please try again.');
    });
  });
});

/* =========================
   Notification
   ========================= */
function showNotification(message) {
  const notif = document.createElement('div');
  notif.className = 'wishlist-notification';
  notif.textContent = message;
  document.body.appendChild(notif);
  setTimeout(() => notif.remove(), 2000);
}
</script>


</body>
</html>
