<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shampoo Product</title>

    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm p-4" style="max-width: 650px; margin: auto;">
        <h2 class="mb-4 text-center">Edit Shampoo Product</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div class="mb-3">
                <label class="form-label">Shampoo Name</label>
                <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" class="form-control" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" class="form-control" step="0.01" name="price" value="{{ old('price', $product->price) }}" required>
            </div>

            <!-- Brand -->
            <div class="mb-3">
                <label class="form-label">Brand</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}" required>
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-select" required>
                    <option value="" disabled>Select Category</option>
                    <option value="Anti-dandruff" {{ old('category', $product->category) == 'Anti-dandruff' ? 'selected' : '' }}>Anti-dandruff</option>
                    <option value="Moisturizing" {{ old('category', $product->category) == 'Moisturizing' ? 'selected' : '' }}>Moisturizing</option>
                    <option value="Hair Fall Control" {{ old('category', $product->category) == 'Hair Fall Control' ? 'selected' : '' }}>Hair Fall Control</option>
                    <option value="Keratin" {{ old('category', $product->category) == 'Keratin' ? 'selected' : '' }}>Keratin</option>
                    <option value="Kids Shampoo" {{ old('category', $product->category) == 'Kids Shampoo' ? 'selected' : '' }}>Kids Shampoo</option>
                </select>
            </div>

            <!-- Current Image -->
            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" width="120" class="img-thumbnail mb-2">
                @else
                    <p class="text-muted">No image uploaded yet.</p>
                @endif
            </div>

            <!-- Upload New Image -->
            <div class="mb-3">
                <label class="form-label">Change Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('products.index') }}" class="btn btn-secondary px-4">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">Update Product</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>
