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
    <div class="alert">
      {{ session('success') }}
    </div>
  @endif

  <div class="product-header">
    <h2>🛍 Product Management</h2>
    <button type="button" class="btn-custom" onclick="openModal()">Add Product</button>
  </div>

  <div class="product-grid">
    @if(isset($products) && count($products) > 0)
      @foreach($products as $product)
        <div class="product-card">
          {{-- ✅ Use custom storage path --}}
          <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}"> 
            
     
          <div class="product-card-body">
            <h5 class="product-card-title">{{ $product->name }}</h5>
            <p class="product-card-price">₱ {{ number_format($product->price, 2) }}</p>
            <p>{{ $product->description }}</p>
          </div>

          <div class="product-card-footer">
            <a href="{{ route('products.edit', $product->id) }}" class="btn-outline-custom">Edit</a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product?')" style="display:inline-block;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-outline-danger">Delete</button>
            </form>
          </div>
        </div>
      @endforeach
    @else
      <p class="no-products">No products yet.</p>
    @endif
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
  if (e.target == document.getElementById('addProductModal')) {
    closeModal();
  }
}
</script>

</body>
</html>
