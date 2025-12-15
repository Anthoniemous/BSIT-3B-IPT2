<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Make Product</title>

    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm p-4" style="max-width: 650px; margin: auto;">
        <h2 class="mb-4 text-center">Edit Make Product</h2>

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

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div class="mb-3">
                <label class="form-label">Product Name</label>
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

            <!-- Brand -->
                <div class="mb-4">
                    <label class="block text-gray-800 font-semibold mb-2">Brand</label>
                    <select name="brand" class="w-full p-2 border rounded">
                        <option disabled>-- Select Brand --</option>

                        <option value="Mary" {{ $product->brand == 'Mary' ? 'selected' : '' }}>Mary</option>
                        <option value="MakeupX" {{ $product->brand == 'MakeupX' ? 'selected' : '' }}>MakeupX</option>
                        <option value="BeautyPlus" {{ $product->brand == 'BeautyPlus' ? 'selected' : '' }}>BeautyPlus</option>
                        <option value="GlowUp" {{ $product->brand == 'GlowUp' ? 'selected' : '' }}>GlowUp</option>
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
                <a href="{{ route('admin.products.dashboard') }}" class="btn btn-secondary px-4">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">Update Product</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>
