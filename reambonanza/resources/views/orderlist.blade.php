<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🧾 Orders</title>
    <link rel="stylesheet" href="{{ asset('css/orderlist.css') }}">
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

<div class="container">
    <h1 class="page-title">🧾 Orders</h1>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Check if user has orders --}}
    @if($orders->count() === 0)
        <p class="no-orders">You have no orders yet.</p>
    @else
        <div class="order-table">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $order->order_id }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>{{ $item->product->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                <td>
                                    <span class="status {{ strtolower($order->status) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pagination-container">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif

    <div class="mt-6 text-center">
        <a href="{{ url('/userdashboard') }}" class="nav-btn">
            ← Back to Dashboard
        </a>
    </div>

</div>

</body>
</html>
