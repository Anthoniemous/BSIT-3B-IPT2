<x-app-layout>
    <!-- Page Body -->
    <!-- Store Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="section-title text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="fs-5 fw-medium fst-italic text-primary">Online Store</p>
                <h1 class="display-6 text-primary">Want to stay healthy? Choose tea taste</h1>
            </div>

            <!-- Search Bar -->
            <div class="d-flex justify-content-center align-items-center mb-4 gap-2">
                <form id="searchForm" class="d-flex" style="max-width: 400px;">
                    <input type="text" id="searchInput" class="form-control rounded-pill px-3" placeholder="Search product name..." required>
                    <button type="submit" class="btn btn-primary rounded-pill ms-2">Search</button>
                </form>
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
                                @php
                                    // Use product_id here too
                                    $inCart = session('cart', collect())->contains('id', $product->product_id);
                                @endphp

                                @if(!$inCart)
                                    <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success rounded-pill py-2 px-4 m-2">
                                            <i class="fa fa-cart-plus me-1"></i> Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('cart.remove', $product->product_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-pill py-2 px-4 m-2">
                                            <i class="fa fa-times me-1"></i> Remove from Cart
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($products->isEmpty())
                    <div class="col-12 text-center">
                        <p>No products available at the moment.</p>
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
        // Search function
        document.addEventListener('DOMContentLoaded', function () {
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');

            searchForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const query = searchInput.value.trim().toLowerCase();
                const items = document.querySelectorAll('.store-item');

                let found = false;
                items.forEach(item => {
                    const name = item.querySelector('h4').textContent.toLowerCase();
                    item.style.display = name.includes(query) ? 'block' : 'none';
                    if (name.includes(query)) found = true;
                });

                if (!found) alert("No product found with that name.");
            });
        });
    </script>
</x-app-layout>
