<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EMPOWERPATH</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F4E1C1; /* Light Brown Background */
            font-family: 'Segoe UI', sans-serif;
        }
        .sidebar {
            background-color: #4B2D19; /* Dark Brown Sidebar */
            height: 100vh;
            padding-top: 20px;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
        }
        .sidebar .nav-link {
            color: white;
        }
        .sidebar .nav-link:hover {
            background-color: #8E5A36;
        }
        .container {
            margin-left: 270px; /* Space for sidebar */
            padding: 20px;
            background-color: white;
            border-radius: 8px;
        }
        .btn-custom {
            background-color: #8E5A36; /* Custom button color */
            color: white;
        }
        .table th, .table td {
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center text-white">Admin Dashboard</h3>
        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a class="nav-link" href="#">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Product Management</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Order Management</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Settings</a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link p-0">Logout</button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="container my-5">
        <h1 class="text-center">Welcome, Admin!</h1>

        @if(Auth::check())
            <p class="text-center">You are logged in as {{ Auth::user()->email }}</p>
        @else
            <p class="text-center">You are logged in as admin@empowerpath.com</p>
        @endif

        <hr>

        <div class="row">
            <!-- Left Side: Add Product -->
            <div class="col-md-4 mb-4">
                <h2>🛍 Product Management</h2>
                <button type="button" class="btn btn-custom mt-2" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    Add Product
                </button>
            </div>

            <!-- Right Side: Product List -->
            <div class="col-md-8">
                <h2>Existing Products</h2>

                @if(isset($products) && count($products) > 0)
                    <table class="table table-bordered mt-3">
                        <thead style="background-color:#8E5A36; color:white;">
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>₱ {{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->description }}</td>
                                <td>
                                    <!-- Button trigger Edit Modal -->
                                    <button type="button" class="btn btn-warning mb-1" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $product->id }}">
                                        Edit
                                    </button>

                                    <!-- Edit Product Modal -->
                                    <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="background-color: #F4E1C1;">
                                                <div class="modal-header" style="border-bottom:none;">
                                                    <h5 class="modal-title fw-bold" id="editProductModalLabel{{ $product->id }}">Edit Product</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('products.update', $product->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="edit-product-name-{{ $product->id }}" class="form-label">Product Name:</label>
                                                            <input type="text" class="form-control" id="edit-product-name-{{ $product->id }}" name="name" value="{{ $product->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit-product-price-{{ $product->id }}" class="form-label">Price:</label>
                                                            <input type="number" step="0.01" class="form-control" id="edit-product-price-{{ $product->id }}" name="price" value="{{ $product->price }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit-product-description-{{ $product->id }}" class="form-label">Description:</label>
                                                            <textarea class="form-control" id="edit-product-description-{{ $product->id }}" name="description">{{ $product->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="border-top:none;">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-warning">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Button trigger Delete Modal -->
                                    <button type="button" class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#deleteProductModal{{ $product->id }}">
                                        Delete
                                    </button>

                                    <!-- Delete Product Modal -->
                                    <div class="modal fade" id="deleteProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteProductModalLabel{{ $product->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="background-color: #F4E1C1;">
                                                <div class="modal-header" style="border-bottom:none;">
                                                    <h5 class="modal-title fw-bold" id="deleteProductModalLabel{{ $product->id }}">Delete Product</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete <strong>{{ $product->name }}</strong>?</p>
                                                </div>
                                                <div class="modal-footer" style="border-top:none;">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No products available yet.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #F4E1C1;">
                <div class="modal-header" style="border-bottom:none;">
                    <h5 class="modal-title fw-bold" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="product-name" class="form-label">Product Name:</label>
                            <input type="text" class="form-control" id="product-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="product-price" class="form-label">Price:</label>
                            <input type="number" step="0.01" class="form-control" id="product-price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="product-description" class="form-label">Description:</label>
                            <textarea class="form-control" id="product-description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top:none;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-custom">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
