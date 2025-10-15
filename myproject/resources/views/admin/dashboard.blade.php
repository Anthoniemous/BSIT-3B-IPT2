<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Coffee Shop</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* --- General --- */
    body {
      background: #2B1B0E;
      font-family: 'Roboto', sans-serif;
      color: #F0E6D2;
      margin: 0;
    }

    h1, h2, h3, h5 {
      font-family: 'Merriweather', serif;
      color: #FFD699;
    }

    a { text-decoration: none; }

    /* --- Top Navigation --- */
    .top-nav {
      background-color: #3B2615;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.5);
      position: fixed;
      width: 100%;
      z-index: 1000;
      flex-wrap: wrap;
    }

    .top-nav .nav-links a {
      margin-left: 20px;
      font-weight: 500;
      color: #FFD699;
      transition: color 0.3s;
    }

    .top-nav .nav-links a:hover {
      color: #FFA500;
    }

    .container {
      padding-top: 90px;
    }

    /* --- Alerts --- */
    .alert {
      border-radius: 10px;
      background-color: #4B2D19;
      color: #FFD699;
    }

    /* --- Product Cards --- */
    .product-card {
      background-color: #3B2615;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.5);
      transition: transform 0.2s, box-shadow 0.2s;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.7);
    }

    .product-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 1px solid #5C3A21;
    }

    .product-card-body {
      padding: 15px;
      flex: 1;
    }

    .product-card-title {
      font-weight: 700;
      font-size: 1.2rem;
      margin-bottom: 5px;
      color: #FFD699;
    }

    .product-card-price {
      font-weight: 500;
      margin-bottom: 10px;
      color: #FFA500;
    }

    .product-card-footer {
      padding: 10px 15px;
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }

    /* --- Buttons --- */
    .btn-custom {
      background-color: #FFA500;
      color: #3B2615;
      border-radius: 50px;
      font-weight: 500;
      transition: all 0.2s;
    }

    .btn-custom:hover {
      background-color: #FFD699;
      transform: translateY(-2px);
    }

    .btn-outline-custom {
      border: 1px solid #FFD699;
      color: #FFD699;
      border-radius: 50px;
      transition: all 0.2s;
    }

    .btn-outline-custom:hover {
      background-color: #FFD699;
      color: #3B2615;
    }

    /* --- Modal --- */
    .modal-content {
      background-color: #3B2615;
      border-radius: 15px;
      color: #F0E6D2;
    }

    .modal-header h5, .modal-footer button {
      color: #FFD699;
    }

    /* --- Responsive --- */
    @media (max-width: 768px) {
      .product-card img {
        height: 180px;
      }
    }
  </style>
</head>
<body>

<!-- Top Navigation -->
<div class="top-nav">
  <h3>☕ Coffee Admin</h3>
  <div class="nav-links d-flex align-items-center">
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="{{ route('products.index') }}"><i class="bi bi-bag"></i> Products</a>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
      @csrf
      <button type="submit" class="btn btn-outline-custom btn-sm">Logout</button>
    </form>
  </div>
</div>

<!-- Main Content -->
<div class="container">
  <h1 class="text-center mb-4">Welcome, {{ Auth::user()->name ?? 'Admin' }}!</h1>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
    <h2>🛍 Product Management</h2>
    <button type="button" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
  </div>

  <div class="row g-4">
    @if(isset($products) && count($products) > 0)
      @foreach($products as $product)
        <div class="col-md-6 col-lg-4">
          <div class="product-card">
            <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}">
            <div class="product-card-body">
              <h5 class="product-card-title">{{ $product->name }}</h5>
              <p class="product-card-price">₱ {{ number_format($product->price,2) }}</p>
              <p>{{ $product->description }}</p>
            </div>
            <div class="product-card-footer">
              <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-custom btn-sm">Edit</a>
              <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm"
                  onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    @else
      <p class="text-center mt-4">No products yet.</p>
    @endif
  </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="productName" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="productName" required>
          </div>
          <div class="mb-3">
            <label for="productPrice" class="form-label">Price</label>
            <input type="number" name="price" class="form-control" id="productPrice" step="0.01" required>
          </div>
          <div class="mb-3">
            <label for="productDescription" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="productDescription"></textarea>
          </div>
          <div class="mb-3">
            <label for="productImage" class="form-label">Image</label>
            <input type="file" name="image" class="form-control" id="productImage">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-custom">Add Product</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
