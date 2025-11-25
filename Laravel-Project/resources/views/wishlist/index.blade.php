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
        <div class="header-inner">
            <div class="logo">
                <img src="{{ asset('css/img/logo.jpg') }}" alt="NBA Logo" />
                <span class="brand">NBA Fan Store</span>
            </div>

            <nav class="main-nav">
                <ul>
                    <li><a href="{{ url('/') }}" style="font-weight: bold;">Home</a></li>
                    <li><a href="{{ url('/userdashboard') }}">Shop</a></li>
                    <li><a href="{{ route('orders.index') }}" style="font-weight: bold;">Orders</a></li>
                    <li><a href="{{ route('cart.index') }}" style="font-weight: bold;">Cart</a></li>
                    <li><a href="{{ route('wishlist.index') }}" style="font-weight: bold;">Wishlist</a></li>
                </ul>
            </nav>

            <div class="user-option">
                @auth
                <div class="profile-container">
                    <img
                        src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('css/img/default-avatar.png') }}"
                        alt="Profile"
                        class="profile-pic"
                        id="profileDropdownToggle"
                    />
                    <div class="dropdown-menu" id="profileDropdownMenu">
                        <h4>Welcome, {{ Auth::user()->name }}!</h4>

                        <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="profile_photo" required />
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

    <main class="container mt-4">
        <h1 class="page-title text-center mb-4">Your Wishlist</h1>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <div class="order-table table-responsive">
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
                            <img
                                src="{{ asset('storage/' . $item->product->image) }}"
                                alt="{{ $item->product->product_name }}"
                                class="product-image"
                            />
                            <span class="product-name">{{ $item->product->product_name }}</span>
                        </td>
                        <td>{{ $item->product->brand ?? 'Unknown Brand' }}</td>
                        <td>
                            <form method="POST" action="{{ route('wishlist.moveToCart', $item->id) }}" style="display:inline-block;">
                                @csrf
                                @if($item->hasSizes)
                                    <select name="size" class="size-select form-select form-select-sm" required>
                                        <option value="" selected disabled>Select Size</option>
                                        <option value="36">36</option>
                                        <option value="37">37</option>
                                        <option value="38">38</option>
                                        <option value="39">39</option>
                                        <option value="40">40</option>
                                        <option value="41">41</option>
                                    </select>
                                @endif
                                <button type="submit" class="btn btn-primary btn-sm">Move to Cart</button>
                            </form>
                        </td>
                        <td>₱{{ number_format($item->product->price, 2) }}</td>
                        <td>
                            <form method="POST" action="{{ route('wishlist.remove', $item->id) }}" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Your wishlist is empty.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary me-2">Back to Dashboard</a>
        </div>
    </main>

    <script>
        document.getElementById('profileDropdownToggle').addEventListener('click', function () {
            document.getElementById('profileDropdownMenu').classList.toggle('active');
        });

        window.addEventListener('click', function (e) {
            const menu = document.getElementById('profileDropdownMenu');
            const toggle = document.getElementById('profileDropdownToggle');
            if (!menu.contains(e.target) && !toggle.contains(e.target)) {
                menu.classList.remove('active');
            }
        });
    </script>
</body>
</html>
