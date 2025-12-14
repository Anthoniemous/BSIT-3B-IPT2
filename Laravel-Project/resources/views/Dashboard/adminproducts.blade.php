<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/admindashboard.css') }}">
</head>

<body>
    <!-- 🎨 SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
            <p>Product Management</p>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="active">
                    <svg viewBox="0 0 24 24">
                       <!-- <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/> -->
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="openAddModal(); return false;">
                    <svg viewBox="0 0 24 24">
                        <!-- <path d="M20 6h-2.18c.11-.31.18-.65.18-1a2.996 2.996 0 0 0-5.5-1.65l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm11 15H4v-2h16v2zm0-5H4V8h5.08L7 10.83 8.62 12 11 8.76l1-1.36 1 1.36L15.38 12 17 10.83 14.92 8H20v6z"/> -->
                    </svg>
                    <span>Add New Products</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders.index') }}">
                    <svg viewBox="0 0 24 24">
                        <!--<path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>-->
                    </svg>
                    <span>View Orders</span>
                </a>
            </li>
        </ul>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </aside>

    <!-- 📱 MAIN CONTENT -->
    <div class="main-content">
        <!-- TOP BAR -->
        <div class="top-bar">
            <h1>Product Dashboard</h1>
            <p>Welcome back! Here's what's happening with your store today.</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success" id="success-message">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error" id="error-message">{{ session('error') }}</div>
        @endif

        <!-- FILTER SECTION -->
        <div class="filter-container">
            <form id="filterForm" action="{{ route('admin.products.index') }}" method="GET" class="filter-form">
                <input type="text" name="search" placeholder="Search products..." value="{{ $search }}">

                <select name="category">
                    <option value="all">All Categories</option>
                    <option value="Basketball Shoes" {{ $category=='Basketball Shoes' ? 'selected' : '' }}>Basketball Shoes</option>
                    <option value="Running Shoes" {{ $category=='Running Shoes' ? 'selected' : '' }}>Running Shoes</option>
                    <option value="Soccer Shoes" {{ $category=='Soccer Shoes' ? 'selected' : '' }}>Soccer Shoes</option>
                    <option value="Accessories" {{ $category=='Accessories' ? 'selected' : '' }}>Accessories</option>
                </select>

                <select name="sort">
                    <option value="">Sort By</option>
                    <option value="newest" {{ $sort=='newest' ? 'selected' : '' }}>Newest</option>
                    <option value="price_high_low" {{ $sort=='price_high_low' ? 'selected' : '' }}>Price: High–Low</option>
                    <option value="price_low_high" {{ $sort=='price_low_high' ? 'selected' : '' }}>Price: Low–High</option>
                </select>
            </form>
        </div>

        <!-- TABLE -->
        <div class="table-container">
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
                        <td>{{ $product->brand ?? '—' }}</td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td>
                            @if ($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" alt="Product">
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <!-- ✅ SIMPLE LINK - NO MODAL, NO JAVASCRIPT -->
                            <a href="/admin/products/{{ $product->product_id }}/edit" class="btn btn-warning">
                                Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: rgba(255,255,255,0.5);">
                            No products found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 🆕 ADD PRODUCT MODAL -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Product</h2>
                <span class="close" onclick="closeAddModal()">&times;</span>
            </div>
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" name="product_name" id="product_name" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="brand">Brand</label>
                        <input type="text" name="brand" id="brand">
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" id="category" required>
                            <option value="">Select Category</option>
                            <option value="Basketball Shoes">Basketball Shoes</option>
                            <option value="Running Shoes">Running Shoes</option>
                            <option value="Soccer Shoes">Soccer Shoes</option>
                            <option value="Jerseys">Jerseys</option>
                            <option value="Accessories">Accessories</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <input type="file" name="image" id="image" accept="image/*">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Filter form auto-submit
        const form = document.getElementById('filterForm');
        document.querySelectorAll('#filterForm input, #filterForm select')
            .forEach(el => el.addEventListener('change', () => form.submit()));

        // Modal functions
        function openAddModal() {
            const modal = document.getElementById('addModal');
            modal.style.display = 'block';
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        }

        function closeAddModal() {
            const modal = document.getElementById('addModal');
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const addModal = document.getElementById('addModal');
            if (event.target == addModal) {
                closeAddModal();
            }
        }

        // Auto-hide alerts
        setTimeout(() => {
            const successMsg = document.getElementById('success-message');
            const errorMsg = document.getElementById('error-message');
            if (successMsg) {
                successMsg.style.opacity = '0';
                setTimeout(() => successMsg.remove(), 300);
            }
            if (errorMsg) {
                errorMsg.style.opacity = '0';
                setTimeout(() => errorMsg.remove(), 300);
            }
        }, 3000);
    </script>
</body>
</html>