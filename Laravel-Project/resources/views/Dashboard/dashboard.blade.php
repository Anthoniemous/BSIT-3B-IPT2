<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/admindashboard.css') }}">
</head>
<body>
    <header class="dashboard-header">
        <div class="header-content">
            <div class="header-left">
                <h1>Admin Dashboard</h1>
            </div>

            <div class="header-buttons">
                <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
                <a href="{{ route('admin.orders') }}" class="btn btn-primary">View All Orders</a>
            </div>

            <div class="header-right">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-logout">Logout</button>
                </form>
            </div>

        </div>
    </header>

    <div class="filter-container">
        <form id="filterForm" action="{{ route('products.index') }}" method="GET" class="filter-form">
            <input type="text" name="search" id="searchInput" placeholder="Search products..." value="{{ $search ?? '' }}">

            <select name="category" id="categorySelect">
                <option value="all">All Categories</option>
                <option value="Basketball Shoes" {{ (isset($category) && $category == 'Basketball Shoes') ? 'selected' : '' }}>Basketball Shoes</option>
                <option value="Running Shoes" {{ (isset($category) && $category == 'Running Shoes') ? 'selected' : '' }}>Running Shoes</option>
                <option value="Soccer Shoes" {{ (isset($category) && $category == 'Soccer Shoes') ? 'selected' : '' }}>Soccer Shoes</option>
                <option value="Lifestyle Shoes" {{ (isset($category) && $category == 'Lifestyle Shoes') ? 'selected' : '' }}>Lifestyle Shoes</option>
                <option value="Accessories" {{ (isset($category) && $category == 'Accessories') ? 'selected' : '' }}>Accessories</option>
            </select>

            <select name="sort" id="sortSelect">
                <option value="">Sort By</option>
                   <option value="newest" {{ request('sort')=='newest' ? 'selected':'' }}>Newest</option>
                    <option value="price_high_low" {{ request('sort')=='price_high_low' ? 'selected':'' }}>Price: High-Low</option>
                    <option value="price_low_high" {{ request('sort')=='price_low_high' ? 'selected':'' }}>Price: Low-High</option>
            </select>
        </form>
    </div>

    <!-- 📋 Table Section -->
    <main class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Brand</th>   
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->description }}</td>

                    <!-- ⭐ ADDED BRAND & SIZE -->
                    <td>{{ $product->brand ?? '—' }}</td>

                    <td>₱{{ number_format($product->price, 2) }}</td>

                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" width="60">
                        @else
                            N/A
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </main>

    <!-- 🟢 Live Filter Script -->
    <script>
        const form = document.getElementById('filterForm');
        const searchInput = document.getElementById('searchInput');
        const categorySelect = document.getElementById('categorySelect');
        const sortSelect = document.getElementById('sortSelect');

        let typingTimer;
        const typingDelay = 300;

        searchInput.addEventListener('keyup', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => form.submit(), typingDelay);
        });

        categorySelect.addEventListener('change', () => form.submit());
        sortSelect.addEventListener('change', () => form.submit());
    </script>

</body>
</html>
