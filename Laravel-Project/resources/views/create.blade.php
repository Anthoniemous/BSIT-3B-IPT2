<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
    body {
       background: url('/css/img/background.jpg') no-repeat center center fixed;
        background-size: 100% auto; 
        font-family: 'Roboto', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
    }

   

    .card {
        max-width: 600px;
        width: 100%;
        margin: 2rem auto;
        border-radius: 16px;
        border: none;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08); /* soft shadow */
        background-color: #ffffff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-weight: 700;
        color: #2b2d42;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px 12px;
        border: 1px solid #ccc;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 6px rgba(0, 123, 255, 0.3);
    }

    .btn-primary, .btn-secondary {
        min-width: 130px;
        border-radius: 30px;
        font-weight: 600;
        padding: 10px 16px;
        transition: background-color 0.2s ease, transform 0.1s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    .btn-secondary:hover {
        background-color: #6c757d;
        transform: translateY(-2px);
    }

    .alert {
        margin-top: 1rem;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.95rem;
    }
</style>
</head>
<body>
    <div class="container">
        <div class="card shadow p-4">
            <h2 class="mb-4 text-center">Add Product</h2>

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
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" name="product_name" id="product_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" id="price" step="0.01" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" class="btn btn-primary">Save Product</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
