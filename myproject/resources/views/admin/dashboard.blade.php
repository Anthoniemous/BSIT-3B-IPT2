<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Products | Coffee Shop</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- DarkPan -->
  <link rel="stylesheet" href="{{ asset('admin/darkpan/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/darkpan/css/light.css') }}">

  <!-- Your existing CSS (cards/modal) -->
  <link rel="stylesheet" href="{{ asset('admin/dashboard.css') }}">
</head>
<body>

<div class="container-fluid position-relative d-flex p-0">

  <!-- Spinner -->
  <div id="spinner" class="show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"></div>
  </div>

  <!-- Sidebar -->
  <div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
      <a href="{{ route('admin.dashboard') }}" class="navbar-brand mx-4 mb-3">
        <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Coffee Admin</h3>
      </a>

      <div class="d-flex align-items-center ms-4 mb-4">
        <div class="position-relative">
          <img class="rounded-circle" src="https://via.placeholder.com/40" alt="" style="width:40px;height:40px;">
          <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
        </div>
        <div class="ms-3">
          <h6 class="mb-0">{{ Auth::user()->name ?? 'Admin' }}</h6>
          <span>Admin</span>
        </div>
      </div>

      <div class="navbar-nav w-100">
        <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link">
          <i class="fa fa-tachometer-alt me-2"></i>Dashboard
        </a>

        <a href="{{ route('products.index') }}" class="nav-item nav-link active">
          <i class="fa fa-shopping-bag me-2"></i>Products
        </a>

        <a href="{{ route('admin.orders.index') }}" class="nav-item nav-link">
          <i class="fa fa-receipt me-2"></i>Orders
        </a>

        <a href="{{ route('admin.logs') }}" class="nav-item nav-link">
          <i class="fa fa-history me-2"></i>Activity Logs
        </a>
      </div>
    </nav>
  </div>

  <!-- Content -->
  <div class="content">

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
      <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
      </a>

      <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fa fa-user me-lg-2"></i>
            <span class="d-none d-lg-inline-flex">{{ Auth::user()->name ?? 'Admin' }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
              @csrf
              <button class="dropdown-item" type="submit">Log Out</button>
            </form>
          </div>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container-fluid pt-4 px-4">
      <div class="bg-secondary rounded p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h4 class="mb-0">Product Management</h4>
            <small class="text-muted">Manage products (XML rendered)</small>
          </div>
          <button type="button" class="btn btn-primary" onclick="openModal()">
            <i class="fa fa-plus me-2"></i>Add Product
          </button>
        </div>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="product-grid" id="productGrid">
          <!-- Products Loaded via XML -->
        </div>

      </div>
    </div>

  </div>
</div>

<!-- Add Product Modal (same as yours) -->
<div id="addProductModal" class="modal">
  <div class="modal-content">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-header">
        <h5>Add Product</h5>
        <span class="close" onclick="closeModal()">&times;</span>
      </div>

      <div class="modal-body">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Brand</label>
        <input type="text" name="brand" placeholder="Optional">

        <label>Category</label>
        <select name="category_id" required>
          <option value="" disabled selected>Select Category</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>

        <label>Price</label>
        <input type="number" name="price" step="0.01" required>

        <label>Description</label>
        <textarea name="description"></textarea>

        <label>Image</label>
        <input type="file" name="image">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="closeModal()">Cancel</button>
        <button type="submit" class="btn btn-primary">Add Product</button>
      </div>
    </form>
  </div>
</div>

<!-- JS libs -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DarkPan JS -->
<script src="{{ asset('admin/darkpan/js/main.js') }}"></script>

<!-- Your existing JS (unchanged logic) -->
<script>
function openModal() {
  document.getElementById('addProductModal').style.display = 'flex';
}
function closeModal() {
  document.getElementById('addProductModal').style.display = 'none';
}
window.onclick = function(e) {
  if (e.target == document.getElementById('addProductModal')) closeModal();
}

const routes = {
  edit: "{{ route('products.edit', ':id') }}",
  destroy: "{{ route('products.destroy', ':id') }}"
};

document.addEventListener("DOMContentLoaded", () => {
  const productGrid = document.getElementById("productGrid");

  function renderProduct(product) {
    const div = document.createElement("div");
    div.classList.add("product-card");

    const editURL = routes.edit.replace(':id', product.id);
    const deleteURL = routes.destroy.replace(':id', product.id);

    div.innerHTML = `
      <img src="/storage/products/${product.image}" alt="${product.name}">
      <div class="product-card-body">
        <h5 class="product-card-title">${product.name}</h5>
        <p class="product-card-price">₱ ${parseFloat(product.price).toFixed(2)}</p>
        <p>Brand: ${product.brand ?? '-'}</p>
        <p>Category: ${product.category_name ?? '-'}</p>
        <p>${product.description ?? ''}</p>
      </div>
      <div class="product-card-footer">
        <a href="${editURL}" class="btn btn-outline-primary btn-sm">Edit</a>
        <form action="${deleteURL}" method="POST" onsubmit="return confirm('Delete this product?')" style="display:inline-block;">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
        </form>
      </div>
    `;
    productGrid.appendChild(div);
  }

  fetch("{{ asset('storage/products.xml') }}")
    .then(res => res.text())
    .then(xmlStr => {
      localStorage.setItem('productsXML', xmlStr);
      const parser = new DOMParser();
      const xml = parser.parseFromString(xmlStr, "application/xml");

      productGrid.innerHTML = "";

      xml.querySelectorAll("product").forEach(p => {
        renderProduct({
          id: p.querySelector("id")?.textContent,
          name: p.querySelector("name")?.textContent,
          brand: p.querySelector("brand")?.textContent,
          category_name: p.querySelector("category_name")?.textContent,
          price: p.querySelector("price")?.textContent,
          description: p.querySelector("description")?.textContent,
          image: p.querySelector("image")?.textContent
        });
      });
    })
    .catch(err => console.log("Failed to load XML:", err));
});
</script>

</body>
</html>
