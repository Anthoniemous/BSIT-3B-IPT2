@extends('admin.layout')

@section('title', 'Products')

@section('content')
<div class="container-fluid pt-4 px-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Header + Actions -->
    <div class="bg-light rounded p-4 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h6 class="mb-0">Products</h6>

            <div class="d-flex gap-2 align-items-center flex-wrap">
                <form id="searchForm" class="d-flex" style="max-width: 380px;">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search product name..." required>
                    <button type="submit" class="btn btn-primary ms-2">Search</button>
                </form>

                <button class="btn btn-success"
                        data-bs-toggle="modal"
                        data-bs-target="#addProductModal">
                    + Add Product
                </button>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-light rounded p-4">
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th style="width:80px;">Image</th>
                        <th>Product</th>
                        <th style="width:130px;">Price</th>
                        <th style="width:140px;">Stock</th>
                        <th style="width:130px;">Status</th>
                        <th style="width:260px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <img class="rounded"
                                     src="{{ $product->image ? asset('img/products/' . $product->image) : asset('img/store-product-1.jpg') }}"
                                     alt="{{ $product->name }}"
                                     style="width:60px;height:60px;object-fit:cover;">
                            </td>

                            <td>
                                <div class="fw-semibold">{{ $product->name }}</div>
                                <small class="text-muted">
                                    {{ \Illuminate\Support\Str::limit($product->description, 70) }}
                                </small>
                            </td>

                            <td>₱{{ number_format($product->price, 2) }}</td>

                            <td>{{ $product->stock_quantity }}</td>

                            <td>
                                <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex gap-2 flex-wrap">
                                    <button
                                        class="btn btn-sm btn-warning editProductBtn"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-description="{{ $product->description }}"
                                        data-price="{{ $product->price }}"
                                        data-stock="{{ $product->stock_quantity }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editProductModal">
                                        Edit
                                    </button>

                                    <form action="{{ route('product.toggleStatus', $product->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="btn btn-sm {{ $product->status == 'active' ? 'btn-secondary' : 'btn-success' }}">
                                            {{ $product->status == 'active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No products available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" step="0.01" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" name="stock_quantity" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" id="edit_price" step="0.01" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" name="stock_quantity" id="edit_stock_quantity" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="image" class="form-control">
                        <small class="text-muted">Leave blank to keep current image.</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Edit button -> fill modal + set action
    const editButtons = document.querySelectorAll('.editProductBtn');
    const form = document.getElementById('editProductForm');

    editButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;

            document.getElementById('edit_name').value = this.dataset.name || '';
            document.getElementById('edit_description').value = this.dataset.description || '';
            document.getElementById('edit_price').value = this.dataset.price || '';
            document.getElementById('edit_stock_quantity').value = this.dataset.stock || '';

            form.action = `/product/${id}`;
        });
    });

    // Search -> open edit modal for the first match
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');

    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const searchValue = (searchInput.value || '').trim().toLowerCase();
            if (!searchValue) return;

            let foundBtn = null;
            editButtons.forEach(btn => {
                if (!foundBtn && (btn.dataset.name || '').toLowerCase().includes(searchValue)) {
                    foundBtn = btn;
                }
            });

            if (!foundBtn) {
                alert("No product found with that name.");
                return;
            }

            // trigger the modal fill
            foundBtn.click();

            // show modal
            const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
            editModal.show();
        });
    }
});
</script>
@endpush
