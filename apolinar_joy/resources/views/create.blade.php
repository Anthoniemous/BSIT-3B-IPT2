<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Make up Product</title>
  <link rel="stylesheet" href="{{ asset('css/create.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
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

      <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Product Name -->
        <div class="mb-3">
          <label for="product_name" class="form-label">Product Name </label>
          <input type="text" name="product_name" class="form-control" required>
        </div>

        <!-- Brand -->
        <div class="mb-3">
          <label for="brand" class="form-label">Brand</label>
          <input type="text" name="brand" id="brand" class="form-control" placeholder="Example: Dove, Sunsilk, Head & Shoulders" required>
        </div>

        <!-- Category -->
       <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <select name="brand" id="brand" class="form-control" required>
                    <option value="" disabled selected>Select Brand</option>
                    <option value="Mary">Mary</option>
                    <option value="MakeupX">MakeupX</option>
                    <option value="BeautyPlus">BeautyPlus</option>
                    <option value="GlowUp">GlowUp</option>
                </select>
            </div>


        <!-- Description -->
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea name="description" id="description" class="form-control" rows="3" placeholder="Highlight the shine & scent"></textarea>
        </div>

        <!-- Price -->
        <div class="mb-3">
          <label for="price" class="form-label">Price</label>
          <input type="number" name="price" step="0.01" class="form-control" required>
        </div>

        <!-- Image -->
        <div class="mb-4">
          <label for="image" class="form-label">Make up Image</label>
          <input type="file" name="image" id="image" class="form-control">
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-center gap-3">
          <button type="submit" class="btn btn-primary">Save Make up</button>
          <a href="{{ route('admin.products.dashboard') }}" class="btn btn-secondary">Cancel</a>
        </div>

      </form>
    </div>
  </div>
</body>
</html>
