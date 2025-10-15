<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product - Coffee Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #2B1B0E;
      font-family: 'Roboto', sans-serif;
      color: #F0E6D2;
    }

    .card {
      background-color: #3B2615;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.5);
      color: #F0E6D2;
    }

    h1 {
      font-family: 'Merriweather', serif;
      color: #FFD699;
    }

    label {
      font-weight: 500;
      color: #FFD699;
    }

    input.form-control, textarea.form-control {
      background-color: #4B2D19;
      border: 1px solid #5C3A21;
      color: #F0E6D2;
      border-radius: 8px;
    }

    input.form-control:focus, textarea.form-control:focus {
      background-color: #4B2D19;
      color: #F0E6D2;
      border-color: #FFA500;
      box-shadow: 0 0 0 0.2rem rgba(255, 165, 0, 0.25);
    }

    .btn-custom {
      background-color: #FFA500;
      color: #3B2615;
      font-weight: bold;
      border-radius: 50px;
      transition: all 0.2s;
    }

    .btn-custom:hover {
      background-color: #FFD699;
      transform: translateY(-2px);
    }

    .btn-back {
      background-color: #8C5E3C;
      color: #F0E6D2;
      border-radius: 8px;
      transition: all 0.2s;
    }

    .btn-back:hover {
      background-color: #A67B5B;
      color: #fff;
    }

    img.current-image {
      max-height: 100px;
      border-radius: 8px;
      border: 1px solid #5C3A21;
    }

    .container {
      padding-top: 50px;
      padding-bottom: 50px;
    }
  </style>
</head>
<body>

  <div class="container py-4">
    <div class="card shadow-lg p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>✏️ Edit Product</h1>
        <a href="{{ route('products.index') }}" class="btn btn-back btn-sm">
          ← Back to Product List
        </a>
      </div>

      <form action="{{ route('products.update', $product->id) }}" method="POST" class="mt-3" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Product Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Price:</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Description:</label>
            <textarea name="description" class="form-control" rows="1">{{ $product->description }}</textarea>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Product Image:</label>
          <input type="file" name="image" class="form-control">
          @if($product->image)
            <img src="{{ asset('storage/products/'.$product->image) }}" alt="Current Image" class="mt-2 current-image">
          @endif
        </div>

        <button type="submit" class="btn btn-custom">
          💾 Save Changes
        </button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
