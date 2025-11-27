<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Wishlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/wishlist.css') }}" />
</head>
<body>


<header class="site-header">
  <div class="container header-inner">
    <div class="logo">
      <img src="{{ asset('css/img/image.png') }}" alt="Logo">
      <span class="brand">Glamour Makeup Store 💋</span>
    </div>

    <nav class="main-nav">
      <ul>
        <a href="{{ route('user.dashboard') }}" class="nav-btn">Home</a>
      </ul>
    </nav>

    <div class="user-option">
      @auth
        <a href="{{ route('wishlist.index') }}" class="btn small">💖 Wishlist</a>
        <a href="{{ route('orders.index') }}" class="btn small">Orders</a>
        <a href="{{ route('cart.index') }}" class="btn small">Cart 🛒</a>
        

        <div class="profile-container">
          <img 
            src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('css/img/default-avatar.png') }}" 
            alt="Profile" 
            class="profile-pic" 
            id="profileDropdownToggle"
          >
          <div class="dropdown-menu" id="profileDropdownMenu">
            <h4>Welcome back, {{ Auth::user()->name }}!</h4>
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
    <main class="container mt-4">
        <h1 class="page-title text-center mb-4">💖 Your Wishlist</h1>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Move</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wishlistItems as $item)
                        <tr data-id="{{ $item->id }}">
                            <td class="product-cell">
                                @if($item->product)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         alt="{{ $item->product->product_name }}" 
                                         class="product-image me-2" style="width:50px; height:50px; object-fit:cover;"/>
                                    <span class="product-name">{{ $item->product->product_name }}</span>
                                @else
                                    <span>Product no longer available</span>
                                @endif
                            </td>

                            <td>{{ $item->product->brand ?? 'Unknown Brand' }}</td>

                            <td>
                                @if($item->product)
                                    <form method="POST" action="{{ route('wishlist.moveToCart', $item->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Move to Cart</button>
                                    </form>
                                @endif
                            </td>

                            <td>
                                {{ $item->product ? '₱' . number_format($item->product->price, 2) : '-' }}
                            </td>

                            <td>
                                <form method="POST" action="{{ route('wishlist.remove', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Your wishlist is empty 💔</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ url('/') }}" class="btn btn-secondary">Back to Shop</a>
        </div>
    </main>
</body>
</html>
