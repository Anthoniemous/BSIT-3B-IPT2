<x-app-layout>
    <div class="container py-5 ">
        <h2 class="mb-4 text-center text-primary">My Wishlist</h2>

        @php $wishlist = session('wishlist', []); @endphp

        @if(count($wishlist) > 0)
            <div class="row g-4">

                @foreach($wishlist as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm border-0 rounded-4">

                        <img 
                            src="{{ $item['image'] 
                                ? asset('img/products/' . $item['image']) 
                                : asset('img/store-product-1.jpg') }}" 
                            class="card-img-top rounded-top-4" 
                            alt="{{ $item['name'] }}"
                            style="height: 400px; object-fit: cover;"
                        >

                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $item['name'] }}</h5>
                            <p class="text-primary fw-bold">${{ number_format($item['price'], 2) }}</p>

                            <div class="d-flex justify-content-center gap-2">

                                <!-- Move to Cart -->
                                <form action="{{ route('wishlist.moveToCart', $item['id']) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success rounded-pill px-3">
                                        <i class="fa fa-cart-plus me-1"></i> Move to Cart
                                    </button>
                                </form>

                                <!-- Remove -->
                                <form action="{{ route('wishlist.remove', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger rounded-pill px-3">
                                        <i class="fa fa-trash me-1"></i> Remove
                                    </button>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

        @else
            <p class="text-center mt-5">Your wishlist is empty.</p>
        @endif

    </div>
</x-app-layout>
