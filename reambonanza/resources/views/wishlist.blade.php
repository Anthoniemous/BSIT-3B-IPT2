<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Wishlist </title>
    <link rel="stylesheet" href="{{ asset('css/wishlist.css') }}">
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
    <h2 class="page-title">Your Wishlist </h2>

    @if($wishlist->isEmpty())
        <p class="no-orders">Your wishlist is empty 😢</p>
    @else
        <div class="order-table">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wishlist as $item)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                 alt="{{ $item->product->product_name }}" 
                                 style="width:80px; height:80px; object-fit:cover; border-radius:8px;">
                        </td>
                        <td>{{ $item->product->product_name }}</td>
                        <td>${{ number_format($item->product->price, 2) }}</td>
                        <td class="actions">
                            <!-- Move to Cart -->
                            <form method="POST" action="{{ route('wishlist.moveToCart', $item->product_id) }}">
                                @csrf
                                <button class="btn primary">Move to Cart</button>
                            </form>

                            <!-- Remove -->
                            <form method="POST" action="{{ route('wishlist.remove', $item->product_id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

</body>
</html>
