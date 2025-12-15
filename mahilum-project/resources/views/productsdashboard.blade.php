<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management</title>
    <link rel="stylesheet" href="{{ asset('css/productsdashboard.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo">
                <h1>ADMIN<span>HUB</span></h1>
            </div>
            <nav class="nav-menu">
                <a href="{{ route('dashboard') }}" class="nav-item">
                    <span class="icon"></span>
                    <span>Analytics</span>
                </a>
                <a href="{{ route('admin.products.dashboard') }}" class="nav-item active">
                    <span class="icon"></span>
                    <span>Products</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-item">
                    <span class="icon"></span>
                    <span>Orders</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="nav-item logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <span class="icon"></span>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <div class="header-content">
                    <h1 class="page-title">Products Management</h1>
                    <p class="page-subtitle">Manage your product inventory</p>
                </div>
                <a href="{{ route('admin.products.create') }}" class="btn-primary">
                    <span>➕</span> Add New Product
                </a>
            </header>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Filter and Sort -->
            <div class="filters-container">
                <form method="GET" action="{{ route('admin.products.dashboard') }}" class="filter-form">
                    <select name="sort" onchange="this.form.submit()" class="filter-select">
                        <option value="">Sort by...</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </form>
                <div class="product-count">
                    <strong>{{ $products->count() }}</strong> Products
                </div>
            </div>

            <!-- Products Grid -->
            <section class="products-grid">
                @forelse($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
                        @else
                            <div class="no-image">No Image</div>
                        @endif
                    </div>
                    <div class="product-details">
                        <h3 class="product-name">{{ $product->product_name }}</h3>
                        <p class="product-brand">{{ $product->brand }}</p>
                        <span class="product-category">{{ $product->category }}</span>
                        <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                        <div class="product-price">₱{{ number_format($product->price, 2) }}</div>
                    </div>
                    <div class="product-actions">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn-edit">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon">📦</div>
                    <h2>No Products Yet</h2>
                    <p>Start by adding your first product</p>
                    <a href="{{ route('admin.products.create') }}" class="btn-primary">Add Product</a>
                </div>
                @endforelse
            </section>
        </main>
    </div>
</body>
</html>