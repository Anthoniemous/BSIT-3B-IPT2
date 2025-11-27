<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Coffee Shop</title>

  <!-- External CSS -->
  <link rel="stylesheet" href="{{ asset('admin/dashboard.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>

<!-- Top Navigation -->
<div class="top-nav">
  <h3>☕ Coffee Admin</h3>
  <div class="nav-links">
    <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
    <a href="{{ route('products.index') }}">🛍 Products</a>
    <form action="{{ route('logout') }}" method="POST" class="logout-form">
      @csrf
      <button type="submit" class="logout-btn">Logout</button>
    </form>
  </div>
</div>

<!-- Main Content -->
<div class="container">
  <h1 class="text-center">Welcome, {{ Auth::user()->name ?? 'Admin' }}!</h1>

  @if(session('success'))
    <div class="alert">{{ session('success') }}</div>
  @endif

  <div class="product-header">
    <h2>🛍 Product Management</h2>
    <button type="button" class="btn-custom" onclick="openModal()">Add Product</button>
  </div>

  <div class="product-grid" id="productGrid">
    <!-- Products Loaded via XML -->
  </div>
</div>

<!-- Add Product Modal -->
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
        <button type="button" class="btn-outline-custom" onclick="closeModal()">Cancel</button>
        <button type="submit" class="btn-custom">Add Product</button>
      </div>
    </form>
  </div>
</div>

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

// Laravel Routes
const routes = {
    edit: "{{ route('products.edit', ':id') }}",
    destroy: "{{ route('products.destroy', ':id') }}"
};

// Render Products
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
                <p>${product.description}</p>
            </div>
            <div class="product-card-footer">
                <a href="${editURL}" class="btn-outline-custom">Edit</a>
                <form action="${deleteURL}" method="POST" onsubmit="return confirm('Delete this product?')" style="display:inline-block;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn-outline-danger">Delete</button>
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
    .catch(err => {
        console.log("Failed to load XML:", err);
    });
});
</script>

</body>
</html>
