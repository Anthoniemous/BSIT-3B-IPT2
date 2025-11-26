<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Green Glow Shampoo Shop</title>
  <link rel="stylesheet" href="{{ asset('css/admindashboard.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

  <!-- Header / Nav -->
  <header class="header mb-4 d-flex justify-content-between align-items-center px-4 py-3 bg-white shadow-sm">
    <!-- Left: Title -->
    <h1 class="m-0">Admin Dashboard</h1>

    <!-- Centered Buttons -->
    <div class="d-flex justify-content-center flex-grow-1">
      <a href="{{ route('admin.products.create') }}" class="btn btn-primary me-2">Add Product</a>
      <a href="{{ route('admin.orders') }}" class="btn btn-secondary">View All Orders</a>
    </div>

    <!-- Right: Logout -->
    <div class="logout">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-danger">Logout</button>
      </form>
    </div>
  </header>

  <div class="container">

    <!-- Sorting Form -->
    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-3 d-flex align-items-center gap-2">
      <label for="sort" class="form-label me-2">Sort By:</label>
      <select name="sort" id="sort" class="form-select w-auto" onchange="this.form.submit()">
        <option value="">Featured</option>
        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
        <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price (Low-High)</option>
        <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price (High-Low)</option>
      </select>
    </form>

    <!-- Products Table -->
    <div class="table-responsive table-container">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Brand</th>
            <th>Category</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $product)
          <tr>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->brand ?? 'N/A' }}</td>
            <td>{{ $product->category ?? 'N/A' }}</td>
            <td>{{ $product->description }}</td>
            <td>${{ number_format($product->price, 2) }}</td>
            <td>
              @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
              @else
                No Image
              @endif
            </td>
            <td>
              <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm mb-1">Edit</a>
              <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center">No products found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
