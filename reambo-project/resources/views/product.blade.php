<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Hairnic - Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Poppins:wght@200;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <div class="container-fluid sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light p-0">
                <a href="index.html" class="navbar-brand">
                    <h2 class="text-white">Hairnic</h2>
                </a>
                <button type="button" class="navbar-toggler ms-auto me-0" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="index.html" class="nav-item nav-link">Home</a>
                        <a href="about.html" class="nav-item nav-link">About</a>
                        <a href="product.html" class="nav-item nav-link active">Products</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu bg-light mt-2">
                                <a href="feature.html" class="dropdown-item">Features</a>
                                <a href="how-to-use.html" class="dropdown-item">How To Use</a>
                                <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                                <a href="blog.html" class="dropdown-item">Blog Articles</a>
                                <a href="404.html" class="dropdown-item">404 Page</a>
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                    </div>
                    <a href="" class="btn btn-dark py-2 px-4 d-none d-lg-inline-block">Shop Now</a>
                </div>
            </nav>
        </div>
    </div>

    <!-- Hero -->
    <div class="container-fluid bg-primary hero-header mb-5">
        <div class="container text-center">
            <h1 class="display-4 text-white mb-3 animated slideInDown">Products</h1>
        </div>
    </div>

    <!-- Product Section -->
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary mb-0"><span class="fw-light text-dark">Our Natural</span> Hair Products</h1>
            @auth
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        + Add Product
                    </button>
                    <a href="{{ route('products.storage') }}" class="btn btn-secondary ms-2">
                        View Deactivated Products
                    </a>
                </div>
            @else
                <p class="text-muted mb-0">Please log in to add a product.</p>
            @endauth
        </div>

        <div class="row g-4">
            @foreach($products as $product)
                @if($product->status == 1) {{-- Only active products --}}
                <div class="col-md-6 col-lg-3 mb-3 product-card" id="product-{{ $product->id }}">
                    <div class="card p-3 text-center">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('img/product-1.png') }}"
                             class="card-img-top mb-2" style="height: 200px; object-fit: cover;">
                        <h5>{{ $product->name }}</h5>
                        <p>₱{{ number_format($product->price, 2) }}</p>
                        @auth
                        <button class="btn btn-warning mt-2" onclick="openEditProductModal(@json($product))">Edit</button>
                        <button class="btn btn-danger mt-2" onclick="deactivateProduct({{ $product->id }})">Deactivate</button>
                        @endauth
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Save Product</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form id="editProductForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-header">
              <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" id="editProductName" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" name="price" class="form-control" id="editProductPrice" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" id="editProductImage">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- JS for Edit + Deactivate -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
    function openEditProductModal(product) {
        $('#editProductName').val(product.name);
        $('#editProductPrice').val(product.price);
        $('#editProductForm').attr('action', '/products/' + product.id);
        $('#editProductModal').modal('show');
    }

    function deactivateProduct(id) {
        if (confirm('Are you sure you want to deactivate this product?')) {
            $.ajax({
                url: '/products/' + id + '/deactivate',
                type: 'PUT',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        alert('Product deactivated successfully!');
                        // Option 1: remove product card instantly (no reload)
                        $('#product-' + id).fadeOut(400, function() { $(this).remove(); });
                        // Option 2 (if you prefer reload): uncomment next line
                        // window.location.href = "{{ route('products.index') }}";
                    } else {
                        alert('Failed to deactivate product.');
                    }
                },
                error: function() {
                    alert('Something went wrong. Please try again.');
                }
            });
        }
    }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
