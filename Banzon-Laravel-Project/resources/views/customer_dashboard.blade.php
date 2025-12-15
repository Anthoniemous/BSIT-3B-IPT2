@extends('layouts.customer')

@section('title', 'Online Store')
@section('page_heading', 'Tea Store')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    <li class="breadcrumb-item text-dark" aria-current="page">Store</li>
@endsection

@section('content')
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

                    {{-- ✅ IMPORTANT integration fixes (NO JS changes):
                         1) store-item class moved to the COLUMN so search hides whole card
                         2) data-id added so "Newest" sort works --}}
                    <div class="col-lg-4 col-md-6 wow fadeInUp store-item"
                         data-wow-delay="0.1s"
                         data-id="{{ $product->product_id }}"
                         data-name="{{ $product->name }}"
                         data-price="{{ $product->price }}"
                         data-featured="{{ $product->featured ?? 0 }}">

                        <div class="position-relative text-center" style="width: 407px; height: 505px;">
                            <img class="img-fluid" style="width: 407px; height: 271px;"
                                 src="{{ $product->image ? asset('img/products/' . $product->image) : asset('img/store-product-1.jpg') }}"
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
@endsection

@push('scripts')
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
@endpush
