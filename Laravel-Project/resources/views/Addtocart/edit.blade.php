<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="{{ asset('css/editproduct.css') }}">
</head>

<body class="edit-product-page">

<div class="edit-container">
    <div class="edit-card">
        <div class="edit-header">
            <h2>Edit Product</h2>
            <a href="{{ route('admin.products.index') }}" class="back-link">&times;</a>
        </div>

        <form action="/admin/products/{{ $product->product_id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="edit-body">
                <!-- Product Name -->
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Price -->
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required>
                </div>

                <!-- Stock / Quantity -->
                <div class="form-group">
                    <label>Stock / Quantity</label>
                    <input type="number" name="quantity" min="0" value="{{ old('quantity', $product->quantity) }}" required>
                </div>

                <!-- Brand -->
                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}">
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        @foreach (['Basketball Shoes', 'Running Shoes', 'Jerseys', 'Accessories', 'Soccer Shoes'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $product->category) === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Current Image -->
                <div class="form-group">
                    <label>Current Image</label>
                    @if ($product->image)
                        <div class="current-image-wrapper">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image">
                        </div>
                    @else
                        <p style="color: #999; font-size: 14px;">No image uploaded</p>
                    @endif
                </div>

                <!-- Change Image -->
                <div class="form-group">
                    <label>Change Image</label>
                    <input type="file" name="image">
                </div>

                <!-- Buttons -->
                <div class="form-footer">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>
