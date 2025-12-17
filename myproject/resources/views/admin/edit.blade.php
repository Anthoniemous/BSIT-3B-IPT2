<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product - Coffee Shop</title>

  <link rel="stylesheet" href="{{ asset('admin/edit.css') }}">
</head>
<body>

  <div class="page">
    <div class="container">
      <div class="card">

        <div class="header">
          <div class="title-wrap">
            <h1>✏️ Edit Product</h1>
            <p class="sub">Update product details and image</p>
          </div>

          <a href="{{ route('products.index') }}" class="btn-back">← Back</a>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
          <div class="alert alert-error">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form class="form" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

<div class="grid">
  <div class="form-group">
    <label>Product Name</label>
    <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
  </div>

  <div class="form-group">
    <label>Brand</label>
    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" placeholder="Optional">
  </div>

  <div class="form-group">
    <label>Category</label>
    <select name="category_id" required>
      <option value="" disabled>Select Category</option>
      @foreach($categories as $category)
        <option value="{{ $category->id }}"
          {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
          {{ $category->name }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="form-group">
    <label>Price</label>
    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required>
  </div>

  <div class="form-group full">
    <label>Description</label>
    <textarea name="description" rows="4" placeholder="Optional">{{ old('description', $product->description) }}</textarea>
  </div>
</div>


          <div class="image-row">
            <div class="form-group">
              <label>Change Product Image</label>
              <input type="file" name="image" accept="image/*">
              <small class="hint">PNG/JPG up to 10MB</small>
            </div>

            <div class="preview">
              <div class="preview-title">Current Image</div>
              @if($product->image)
                <img
                  src="{{ asset('storage/products/'.$product->image) }}"
                  alt="Current Image"
                  class="current-image"
                  onerror="this.onerror=null;this.src='https://via.placeholder.com/420x280.png?text=No+Image';"
                >
              @else
                <div class="no-image">No image uploaded</div>
              @endif
            </div>
          </div>

          <div class="actions">
            <a href="{{ route('products.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-custom">💾 Save Changes</button>
          </div>

        </form>

      </div>
    </div>
  </div>

</body>
</html>
