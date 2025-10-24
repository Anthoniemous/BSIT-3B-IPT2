<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    /* ☕ Coffee-Themed Background */
    body {
      background:
        radial-gradient(circle at top left, #c2956b, transparent 60%),
        radial-gradient(circle at bottom right, #6b4226, transparent 60%);
      background-color: #fdf6f0;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      color: #3e2c20;
    }

    /* 🧡 Card Container */
    .card {
      max-width: 650px;
      margin: 4rem auto;
      background: #fffaf5;
      border: none;
      border-radius: 16px;
      box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
      padding: 2.5rem;
    }

    /* ☕ Title */
    .card h2 {
      color: #8b5e34;
      font-weight: 800;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    /* 📝 Form Labels */
    .form-label {
      font-weight: 600;
      color: #5c3d2e;
    }

    /* 🧡 Inputs */
    .form-control {
      border: 1px solid #d4bfa5;
      border-radius: 8px;
      padding: 10px;
      transition: border-color 0.3s ease;
    }

    .form-control:focus {
      border-color: #a47148;
      box-shadow: 0 0 0 0.2rem rgba(164, 113, 72, 0.25);
    }

    /* ☕ Buttons */
    .btn-primary {
      background: linear-gradient(90deg, #8b5e34, #a47148);
      border: none;
      color: #fff;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.3s ease;
      min-width: 140px;
    }

    .btn-primary:hover {
      background: linear-gradient(90deg, #a47148, #8b5e34);
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(139, 94, 52, 0.4);
    }

    .btn-secondary {
      background-color: #d7b26c;
      border: none;
      color: #3e2c20;
      font-weight: 600;
      border-radius: 10px;
      min-width: 140px;
      transition: all 0.3s ease;
    }

    .btn-secondary:hover {
      background-color: #c49a58;
      transform: translateY(-2px);
    }

    /* ✅ Alerts */
    .alert {
      margin-top: 1rem;
      border-radius: 10px;
      font-weight: 500;
    }

    .alert-success {
      background-color: #f2e7dc;
      color: #4a3728;
      border: 1px solid #cbb79c;
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #842029;
      border: 1px solid #f5c2c7;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="card shadow">
      <h2>Add New Product</h2>

      <!-- Success Message -->
      @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <!-- Validation Errors -->
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
          <label for="product_name" class="form-label">Product Name</label>
          <input type="text" name="product_name" id="product_name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea name="description" id="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
          <label for="price" class="form-label">Price</label>
          <input type="number" name="price" id="price" step="0.01" class="form-control" required>
        </div>

        <div class="mb-4">
          <label for="image" class="form-label">Product Image</label>
          <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="d-flex justify-content-center gap-3">
          <button type="submit" class="btn btn-primary">Save Product</button>
          <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
