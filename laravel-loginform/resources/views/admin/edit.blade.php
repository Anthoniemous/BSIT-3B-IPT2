<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product - Moto Mar Shop </title>

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('admin/edit.css') }}">
</head>
<body>

  <div class="container">
    <div class="card">
      <div class="header">
        <h1>✏️ Edit Product</h1>
        <a href="{{ route('products.index') }}" class="btn-back">← Back to Product List</a>
      </div>

      <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-row">
          <div class="form-group">
            <label>Product Name:</label>
            <input type="text" name="name" value="{{ $product->name }}" required>
          </div>

          <div class="form-group">
            <label>Price:</label>
            <input type="number" step="0.01" name="price" value="{{ $product->price }}" required>
          </div>

          <div class="form-group">
            <label>Description:</label>
            <textarea name="description">{{ $product->description }}</textarea>
          </div>
        </div>

        <div class="form-group">
          <label>Product Image:</label>
          <input type="file" name="image">
          @if($product->image)
            <img src="{{ asset('storage/products/'.$product->image) }}" alt="Current Image" class="current-image">
          @endif
        </div>

        <button type="submit" class="btn-custom">💾 Save Changes</button>
      </form>
    </div>
  </div>

</body>
</html>
