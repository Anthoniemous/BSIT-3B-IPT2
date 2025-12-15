<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Purchases | Coffee ' Sodoso</title>

  <link rel="stylesheet" href="{{ asset('customer/purchases.css') }}">
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

      <a class="menu-item" href="{{ route('customer.wishlist') }}">
        <span class="mi">💖</span> <span>Wishlist</span>
        @if(isset($wishlistCount) && $wishlistCount > 0)
          <span class="badge">{{ $wishlistCount }}</span>
        @endif
      </a>

      <a class="menu-item active" href="{{ route('customer.purchases') }}">
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
        <h1 class="page-title">My Purchases</h1>
        <p class="page-sub">Track your orders and view details.</p>
      </div>

      <div class="top-right">
        <div class="profile-menu">
          <button class="profile-btn">
            👤 {{ Auth::user()->name }} <span class="caret">▾</span>
          </button>
          <div class="dropdown">
            <a href="#" id="viewProfileBtn">View Profile</a>
            <a href="{{ route('customer.dashboard') }}">Back to Shop</a>
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

      @if(session('pending'))
        <div class="alert alert-warn">{{ session('pending') }}</div>
      @endif

      <section class="card-box">
        <div class="card-head">
          <h2 class="card-title">Your Orders</h2>
          <a href="{{ route('customer.dashboard') }}" class="btn-link">← Back to Shop</a>
        </div>

        @if($orders->count() === 0)
          <div class="empty-state">Wala pa kay purchases. Pag order sa shop 😊</div>
        @else
          <div class="table-wrap">
            <table class="orders-table">
              <thead>
                <tr>
                  <th>Order #</th>
                  <th>Date</th>
                  <th>Items</th>
                  <th>Payment</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                @foreach($orders as $order)
                  @php
                    $status = strtolower($order->status ?? 'pending');
                  @endphp
                  <tr>
                    <td class="mono">#{{ $order->id }}</td>
                    <td>{{ optional($order->created_at)->format('M d, Y h:i A') }}</td>
                    <td>{{ $order->items->sum('quantity') }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td class="money">₱ {{ number_format($order->total_amount, 2) }}</td>
                    <td>
                      <span class="status-badge
                        {{ $status === 'pending' ? 'pending' : '' }}
                        {{ $status === 'paid' ? 'paid' : '' }}
                        {{ $status === 'processing' ? 'processing' : '' }}
                        {{ $status === 'delivered' ? 'delivered' : '' }}
                        {{ $status === 'cancelled' ? 'cancelled' : '' }}
                      ">
                        {{ strtoupper($order->status ?? 'pending') }}
                      </span>
                    </td>
                    <td>
                      <a class="btn-view" href="{{ route('customer.purchases.show', $order->id) }}">View</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="pagination-wrap">
            {{ $orders->links() }}
          </div>
        @endif
      </section>

    </div>
  </main>
</div>

<!-- PROFILE MODAL (same as other pages) -->
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
  // ===== Profile Modal =====
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
