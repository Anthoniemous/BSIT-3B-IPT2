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
                    <li><a href="{{ url('/userdashboard') }}">Shop</a></li>
                    <li><a href="{{ route('orders.index') }}" style="font-weight: bold;">Orders</a></li>
                    <li><a href="{{ route('cart.index') }}" style="font-weight: bold;">Cart</a></li>
                    <li><a href="{{ route('wishlist.index') }}" style="font-weight: bold;">Wishlist</a></li>
                </ul>
            </nav>

           <div class="user-option">
                @auth
                    <div class="profile-container">
                        <!-- Profile Picture with Status Indicator -->
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
                            <!-- User Info Header -->
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

                            <!-- Success Message -->
                            @if(session('profile_success'))
                                <div class="alert alert-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    {{ session('profile_success') }}
                                </div>
                            @endif

                            <!-- Photo Upload Section -->
                            <div class="photo-upload-section">
                                <h5>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
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
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="17 8 12 3 7 8"></polyline>
                                                <line x1="12" y1="3" x2="12" y2="15"></line>
                                            </svg>
                                            <span id="fileNameDisplay">Choose a photo</span>
                                        </label>
                                        <button type="submit" class="btn-upload" id="uploadBtn" disabled>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            Upload
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="dropdown-divider"></div>

                            <!-- Menu Items -->
                            <div class="dropdown-items">
                                <a href="{{ url('/profile') }}" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    My Profile
                                </a>

                                <a href="{{ route('orders.index') }}" class="dropdown-item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                        <line x1="3" y1="6" x2="21" y2="6"></line>
                                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                                    </svg>
                                    My Orders
                                </a>

                                <a href="{{ url('/settings') }}" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path d="M12 1v6m0 6v6"></path>
                                        <path d="M17 7l-5 5m0 0l-5-5"></path>
                                    </svg>
                                    Settings
                                </a>
                            </div>

                            <div class="dropdown-divider"></div>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                                @csrf
                                <button type="submit" class="dropdown-item logout-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    Logout
                                </button>
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
document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("profileDropdownToggle");
    const menu = document.getElementById("profileDropdownMenu");

    if (!toggle || !menu) return;

    toggle.addEventListener("click", function (e) {
        e.stopPropagation();
        menu.classList.toggle("active");
    });

    document.addEventListener("click", function (e) {
        if (!menu.contains(e.target) && !toggle.contains(e.target)) {
            menu.classList.remove("active");
        }
    });

    menu.addEventListener("click", function (e) {
        e.stopPropagation();
    });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            menu.classList.remove("active");
        }
    });
});
</script>

</body>
</html>
