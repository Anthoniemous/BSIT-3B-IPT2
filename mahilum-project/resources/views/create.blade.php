<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Shampoo Product</title>
  <link rel="stylesheet" href="{{ asset('css/create.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
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

      <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Product Name -->
        <div class="mb-3">
          <label for="product_name" class="form-label">Shampoo Name</label>
          <input type="text" name="product_name" class="form-control" required>
        </div>

      
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="" disabled selected>Select Category</option>
                        <option value="Coffee">Coffee</option>
                        <option value="Beverage">Beverage</option>
                        <option value="Snack">Snack</option>
                        <option value="Merchandise">Merchandise</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="brand" class="form-label">Brand</label>
                    <select name="brand" id="brand" class="form-control" required>
                        <option value="" disabled selected>Select Brand</option>
                        <option value="Brew Haven">Brew Haven</option>
                        <option value="Brew Masters">Brew Masters</option>
                        <option value="Coffee Lovers">Coffee Lovers</option>
                        <option value="Bean & Cup">Bean & Cup</option>
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
          <label for="image" class="form-label">Shampoo Image</label>
          <input type="file" name="image" id="image" class="form-control">
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-center gap-3">
          <button type="submit" class="btn btn-primary">Save Shampoo</button>
          <a href="{{ route('admin.products.dashboard') }}" class="btn btn-secondary">Cancel</a>
        </div>

      </form>
    </div>
  </div>
</body>
</html>
