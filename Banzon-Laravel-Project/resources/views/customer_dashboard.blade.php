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
                <form id="searchForm" class="d-flex" style="width: 400px;">
                    <input type="text" id="searchInput" class="form-control rounded-pill px-3 " placeholder="Search product name..." required>
                    <button type="submit" class="btn btn-primary rounded-pill ms-2">Search</button>
                </form>

                 <!-- Sorting Dropdown -->
                <div>
                    <select id="sortSelect" class="form-select rounded-pill px-3" style="width: 180px;">
                        <option value="" selected disabled>Sort By</option>
                         <option value="newest">Newest</option>
                        <option value="featured">Featured</option>
                        <option value="name_asc">Name (A → Z)</option>
                        <option value="name_desc">Name (Z → A)</option>
                        <option value="price_low_high">Price (Low → High)</option>
                        <option value="price_high_low">Price (High → Low)</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select id="priceFilter" class="form-select rounded-pill w-40">
                        <option value="">All Prices</option>
                        <option value="0-50">₱0 – ₱50</option>
                        <option value="50-100">₱50 – ₱100</option>
                        <option value="100-500">₱100 – ₱500</option>
                        <option value="500-1000">₱500 – ₱1,000</option>
                        <option value="1000-up">₱1,000+</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button id="resetFilters" class="btn btn-secondary rounded-pill w-20">Reset</button>
                </div>
            </div>


            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s"
                         data-name="{{ $product->name }}"
                         data-price="{{ $product->price }}"
                         data-featured="{{ $product->featured ?? 0 }}">
                        <div class="store-item position-relative text-center" style="width: 340px; height: 405px;">
                            <img class="img-fluid" style="width: 407px; height: 250px;" src="{{ $product->image ? asset('img/products/' . $product->image) : 
                            asset('img/store-product-1.jpg') }}" alt="{{ $product->name }}">
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
                                    $inCart = collect(session('cart', []))->contains('id', $product->product_id);
                                @endphp
                                @if(!$inCart)
                                    <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success rounded-pill py-2 px-4 m-2">
                                            <i class="fa fa-cart-plus me-1"></i> Add to Cart
                                        </button>
                                    </form>
                                    <form action="{{ route('wishlist.add', $product->product_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning rounded-pill py-2 px-4 m-2">
                                            <i class="fa fa-heart me-1"></i> Add to Wishlist
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
       document.addEventListener('DOMContentLoaded', function () {
            const sortSelect = document.getElementById('sortSelect');
            if (!sortSelect) return;

            const container = document.querySelector('.row.g-4');
            if (!container) return;

            function getCards() {
                return Array.from(container.querySelectorAll('.col-lg-4.col-md-6[data-name]'));
            }

            // Save original order
            getCards().forEach((card, idx) => {
                if (!card.hasAttribute('data-original-index')) {
                    card.setAttribute('data-original-index', idx);
                }
            });

            function parsePrice(val) {
                if (!val) return 0;
                const cleaned = String(val).replace(/[^0-9.]/g, '');
                return parseFloat(cleaned) || 0;
            }

            sortSelect.addEventListener('change', function () {
                const sortType = this.value;
                const cards = getCards();

                cards.sort((a, b) => {
                    const nameA = a.dataset.name.toLowerCase();
                    const nameB = b.dataset.name.toLowerCase();
                    const priceA = parsePrice(a.dataset.price);
                    const priceB = parsePrice(b.dataset.price);
                    const idA = parseInt(a.dataset.id);
                    const idB = parseInt(b.dataset.id);
                    const featA = parseInt(a.dataset.featured);
                    const featB = parseInt(b.dataset.featured);

                    switch (sortType) {
                        case 'name_asc':
                            return nameA.localeCompare(nameB);
                        case 'name_desc':
                            return nameB.localeCompare(nameA);
                        case 'price_low_high':
                            return priceA - priceB;
                        case 'price_high_low':
                            return priceB - priceA;
                        case 'newest':
                            return idB - idA; // larger ID = newer
                        case 'featured':
                            return featB - featA; // 1 = featured, sort to top
                        default:
                            return parseInt(a.dataset.originalIndex) - parseInt(b.dataset.originalIndex);
                    }
                });

                const frag = document.createDocumentFragment();
                cards.forEach(c => frag.appendChild(c));
                container.appendChild(frag);
            });
        });

       // >>> ADDED CODE START (FILTER SCRIPT)
const priceFilter = document.getElementById('priceFilter');
const resetFilters = document.getElementById('resetFilters');
const filterCards = document.querySelectorAll('.col-lg-4.col-md-6[data-name]');

function applyFilters() {
    const price = priceFilter.value;

    filterCards.forEach(card => {
        const cardPrice = parseFloat(card.dataset.price);
        let show = true;

        if (price) {
            const [min, max] = price.split('-');
            const minVal = parseFloat(min);
            if (max === "up" && cardPrice < minVal) show = false;
            else if (max !== "up") {
                const maxVal = parseFloat(max);
                if (cardPrice < minVal || cardPrice > maxVal) show = false;
            }
        }

        card.style.display = show ? "block" : "none";
    });
}

priceFilter.addEventListener('change', applyFilters);

resetFilters.addEventListener('click', () => {
    priceFilter.value = "";
    filterCards.forEach(card => card.style.display = "block");
});
// >>> ADDED CODE END


    </script>
</x-app-layout>
