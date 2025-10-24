<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Shampoo Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    /* 💚 Green Glow Shampoo Theme Background */
    body {
      background:
        radial-gradient(circle at top left, #b2e5b7, transparent 60%),
        radial-gradient(circle at bottom right, #5a9e6b, transparent 60%);
      background-color: #f0fff5;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      color: #2f4a2f;
    }

    /* 🧴 Card Container */
    .card {
      max-width: 650px;
      margin: 4rem auto;
      background: #f7fff5;
      border: none;
      border-radius: 16px;
      box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
      padding: 2.5rem;
    }

    /* 🌿 Title */
    .card h2 {
      color: #3a6b3a;
      font-weight: 800;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    /* 📝 Form Labels */
    .form-label {
      font-weight: 600;
      color: #2f4a2f;
    }

    /* 💚 Inputs */
    .form-control {
      border: 1px solid #a8d3a0;
      border-radius: 8px;
      padding: 10px;
      transition: border-color 0.3s ease;
    }

    .form-control:focus {
      border-color: #3a6b3a;
      box-shadow: 0 0 0 0.2rem rgba(58, 107, 58, 0.25);
    }

    /* 🌿 Buttons */
    .btn-primary {
      background: linear-gradient(90deg, #3a6b3a, #5a9e6b);
      border: none;
      color: #fff;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.3s ease;
      min-width: 140px;
    }

    .btn-primary:hover {
      background: linear-gradient(90deg, #5a9e6b, #3a6b3a);
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(58, 107, 58, 0.4);
    }

    .btn-secondary {
      background-color: #a0d6a1;
      border: none;
      color: #2f4a2f;
      font-weight: 600;
      border-radius: 10px;
      min-width: 140px;
      transition: all 0.3s ease;
    }

    .btn-secondary:hover {
      background-color: #87c587;
      transform: translateY(-2px);
    }

    /* ✅ Alerts */
    .alert {
      margin-top: 1rem;
      border-radius: 10px;
      font-weight: 500;
    }

    .alert-success {
      background-color: #e0f6e3;
      color: #276634;
      border: 1px solid #a0d6a1;
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
      <h2>Add New Shampoo Product</h2>

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
          <label for="product_name" class="form-label">Shampoo Name</label>
          <input type="text" name="product_name" id="product_name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea name="description" id="description" class="form-control" rows="3" placeholder="Highlight the shine & scent"></textarea>
        </div>

        <div class="mb-3">
          <label for="price" class="form-label">Price</label>
          <input type="number" name="price" id="price" step="0.01" class="form-control" required>
        </div>

        <div class="mb-4">
          <label for="image" class="form-label">Shampoo Image</label>
          <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="d-flex justify-content-center gap-3">
          <button type="submit" class="btn btn-primary">Save Shampoo</button>
          <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
