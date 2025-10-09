<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - EMPOWERPATH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f7e9d2; font-family: 'Segoe UI', sans-serif;">

    <div class="container py-4">
        <div class="card shadow-lg" style="background-color: #fff4e6; border: none; border-radius: 15px;">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="fw-bold" style="color: #6b4e2e;">✏️ Edit Product</h1>
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-dark"
                        style="background-color:#d2b48c; color:white; border:none;">
                        ← Back to Dashboard
                    </a>
                </div>

                <form action="{{ route('products.update', $product->id) }}" method="POST" class="mt-3">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Product Name:</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Price:</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Description:</label>
                            <textarea name="description" class="form-control" rows="1">{{ $product->description }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn" 
                        style="background-color:#a67b5b; color:white; font-weight:bold; border-radius:8px;">
                        💾 Save Changes
                    </button>
                </form>

            </div>
        </div>
    </div>

</body>
</html>
