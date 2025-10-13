<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Coffee Shop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(180deg, #2C1B10 0%, #4B2D19 100%);
            font-family: 'Roboto', sans-serif;
            color: #fff;
        }
        .sidebar { background-color: #3B1F0D; height: 100vh; width: 260px; position: fixed; top: 0; left: 0; padding: 20px; box-shadow: 2px 0 10px rgba(0,0,0,0.5); }
        .sidebar h3 { font-weight: 700; font-size: 1.5rem; text-align: center; margin-bottom: 30px; color: #FFD699; }
        .sidebar .nav-link { color: #fff; margin: 5px 0; padding: 10px 15px; border-radius: 8px; transition: all 0.3s; }
        .sidebar .nav-link:hover { background-color: #8E5A36; color: #fff; }
        .main-content { margin-left: 280px; padding: 30px; }
        h1, h2 { color: #FFD699; }
        .product-card { background-color: #4B2D19; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.3); overflow: hidden; transition: transform 0.2s; display: flex; flex-direction: column; }
        .product-card:hover { transform: translateY(-5px); }
        .product-card img { width: 100%; height: 200px; object-fit: cover; }
        .product-card-body { padding: 15px; flex: 1; }
        .product-card-title { font-weight: 700; font-size: 1.2rem; margin-bottom: 5px; }
        .product-card-price { font-weight: 600; margin-bottom: 10px; }
        .product-card-footer { padding: 10px 15px; display: flex; justify-content: space-between; }
        .btn-custom { background-color: #FFD699; color: #3B1F0D; font-weight: 600; transition: transform 0.2s; }
        .btn-custom:hover { transform: translateY(-2px); }
        .modal-content { background-color: #3B1F0D; color: #fff; }
        .modal-header h5, .modal-footer button { color: #FFD699; }
        .parallax { background-image: url('https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=1400&q=80'); background-attachment: fixed; background-size: cover; background-position: center; padding: 20px 0; }
        .icon-coffee { font-size: 1.2rem; margin-right: 5px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h3>☕ Coffee Admin</h3>
    <ul class="nav flex-column mt-4">
        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-speedometer2 icon-coffee"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-bag icon-coffee"></i> Product Management</a></li>
        <li class="nav-item mt-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link nav-link p-0"><i class="bi bi-box-arrow-right icon-coffee"></i> Logout</button>
            </form>
        </li>
    </ul>
</div>

<div class="main-content parallax">
    <div class="container">
        <h1 class="text-center mb-4">Welcome, Admin!</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show text-dark" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="mb-4">
            <div class="card p-3 bg-transparent border-0">
                <h2>🛍 Product Management</h2>
                <button type="button" class="btn btn-custom mt-3 w-100" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
            </div>
        </div>

        <div class="row g-4">
            @if(isset($products) && count($products) > 0)
                @foreach($products as $product)
                    <div class="col-md-6 col-lg-4">
                        <div class="product-card">
                            <img src="{{ $product->image ? asset('storage/products/'.$product->image) : 'https://via.placeholder.com/300x200.png?text=Coffee' }}" alt="{{ $product->name }}">
                            <div class="product-card-body">
                                <h5 class="product-card-title">{{ $product->name }}</h5>
                                <p class="product-card-price">₱ {{ number_format($product->price,2) }}</p>
                                <p>{{ $product->description }}</p>
                            </div>
                            <div class="product-card-footer">
                                <button class="btn btn-warning btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">No products yet.</p>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
