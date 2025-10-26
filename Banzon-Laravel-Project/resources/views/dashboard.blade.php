<x-app-layout>
    <!-- Page Body -->
    <!-- Store Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="section-title text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="fs-5 fw-medium fst-italic text-primary">Online Store</p>
                <h1 class="display-6 text-primary ">Want to stay healthy? Choose tea taste</h1>
            </div>
            
            <!-- Add Product Button -->
            <div class="d-flex justify-content-center align-items-center mb-4 gap-2">
                <form id="searchForm" class="d-flex" style="max-width: 400px;">
                    <input type="text" id="searchInput" class="form-control rounded-pill px-3" placeholder="Search product name..." required>
                    <button type="submit" class="btn btn-primary rounded-pill ms-2">Search</button>
                </form>

                <button class="btn btn-success rounded-pill py-2 px-4" 
                    data-bs-toggle="modal" 
                    data-bs-target="#addProductModal">
                    + Add Product
                </button>
            </div>

            <!-- Add Product Modal -->
            <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('product.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Product Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" name="price" id="price" step="0.01" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="stock_quantity" class="form-label">Stock Quantity</label>
                                    <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" required>
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
                        <form id="editProductForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="edit_product_id" name="product_id">

                                <div class="mb-3">
                                    <label for="edit_name" class="form-label">Product Name</label>
                                    <input type="text" name="name" id="edit_name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_description" class="form-label">Description</label>
                                    <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_price" class="form-label">Price</label>
                                    <input type="number" name="price" id="edit_price" step="0.01" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_stock_quantity" class="form-label">Stock Quantity</label>
                                    <input type="number" name="stock_quantity" id="edit_stock_quantity" class="form-control" required>
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

            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="store-item position-relative text-center">
                            <img class="img-fluid" 
                                src="{{ asset('img/store-product-1.jpg') }}" 
                                alt="{{ $product->name }}">
                            <div class="p-4">
                                <div class="text-center mb-3">
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                </div>
                                <h4 class="mb-3">{{ $product->name }}</h4>
                                <p>{{ $product->description }}</p>
                                <h4 class="text-primary">${{ number_format($product->price, 2) }}</h4>
                            </div>
                            <div class="store-overlay">
                               <button 
                                    class="btn btn-warning rounded-pill py-2 px-4 m-2 editProductBtn"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-description="{{ $product->description }}"
                                    data-price="{{ $product->price }}"
                                    data-stock="{{ $product->stock_quantity }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editProductModal">
                                    Edit
                                </button>
                                  <form action="{{ route('product.toggleStatus', $product->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                            class="btn rounded-pill py-2 px-4 m-2 
                                            {{ $product->status == 'active' ? 'btn-success' : 'btn-secondary' }}">
                                            {{ $product->status == 'active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($products->isEmpty())
                    <div class="col-12 text-center">
                        <p>No products available. Click “Add Product” to add one.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Store End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark footer mt-5 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-primary mb-4">Our Office</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary me-3"></i>info@example.com</p>
                    <div class="d-flex pt-3">
                        <a class="btn btn-square btn-primary rounded-circle me-2" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-primary rounded-circle me-2" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-primary rounded-circle me-2" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-primary rounded-circle me-2" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-primary mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-primary mb-4">Business Hours</h4>
                    <p class="mb-1">Monday - Friday</p>
                    <h6 class="text-light">09:00 am - 07:00 pm</h6>
                    <p class="mb-1">Saturday</p>
                    <h6 class="text-light">09:00 am - 12:00 pm</h6>
                    <p class="mb-1">Sunday</p>
                    <h6 class="text-light">Closed</h6>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-primary mb-4">Newsletter</h4>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative w-100">
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <script>
    document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.editProductBtn');
    const form = document.getElementById('editProductForm');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const description = this.dataset.description;
            const price = this.dataset.price;
            const stock = this.dataset.stock;

            // Fill modal fields
            document.getElementById('edit_product_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_stock_quantity').value = stock;

            // Set form action dynamically
            form.action = `/product/${id}`;
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const editForm = document.getElementById('editProductForm');

    searchForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const searchValue = searchInput.value.trim().toLowerCase();
        if (!searchValue) return;

        // Find the product in the list
        const productButtons = document.querySelectorAll('.editProductBtn');
        let found = false;

        productButtons.forEach(button => {
            const name = button.dataset.name.toLowerCase();

            if (name.includes(searchValue)) {
                found = true;

                // Auto-fill edit modal
                const id = button.dataset.id;
                const description = button.dataset.description;
                const price = button.dataset.price;
                const stock = button.dataset.stock;

                document.getElementById('edit_product_id').value = id;
                document.getElementById('edit_name').value = button.dataset.name;
                document.getElementById('edit_description').value = description;
                document.getElementById('edit_price').value = price;
                document.getElementById('edit_stock_quantity').value = stock;

                // Set form action
                editForm.action = `/product/${id}`;

                // Show modal
                const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                editModal.show();
            }
        });

        if (!found) {
            alert("No product found with that name.");
        }
    });
});
</script>

</x-app-layout>

