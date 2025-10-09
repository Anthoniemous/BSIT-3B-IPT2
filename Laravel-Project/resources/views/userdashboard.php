<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('public/css/userdashboard.css') }}">
    @endpush

    <div class="container mt-5">
        <h1>User Dashboard</h1>
        <h3>Available Products</h3>
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-3">
                <div class="card mb-3">
                    <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->product_name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->product_name }}</h5>
                        <p class="card-text">${{ number_format($product->price, 2) }}</p>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
