<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Coffee Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
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

    /* --- Main Content --- */
    .main-content {
      margin: 0;
      padding: 90px 30px 30px 30px; /* top padding for navbar */
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

    /* --- Modal --- */
    .modal-content {
      background-color: #3B2615;
      border-radius: 15px;
      color: #F0E6D2;
    }

    .modal-header h5, .modal-footer button {
      color: #FFD699;
    }
  </style>
</head>
<body>

<!-- Navbar -->
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
<div class="main-content">
  @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
