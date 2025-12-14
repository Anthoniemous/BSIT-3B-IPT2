@extends('layouts.app')

@section('content')
<section class="py-5 bg-light" id="cart">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="font-weight-bold text-success">Your Cart</h2>

            <a href="{{ route('products') }}" class="btn btn-outline-primary btn-sm">
                Back to Products
            </a>

            <a href="{{ route('wishlist.index') }}" class="btn btn-outline-secondary btn-sm">
                View Wishlist
            </a>
        </div>

        @if($cartItems->isEmpty())
            <div class="text-center">
                <p class="text-muted">Your cart is empty. Add some products!</p>
            </div>
        @else
            <div class="row">

                @foreach($cartItems as $item)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">

                        <div class="overflow-hidden" style="height: 200px;">
                            <img 
                                src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('assets/images/default.png') }}" 
                                alt="{{ $item->product->name }}" 
                                class="card-img-top img-fluid"
                                style="object-fit: cover; width: 100%; height: 100%;">
                        </div>

                        <div class="card-body text-center">
                            <h5 class="card-title text-dark">{{ $item->product->name }}</h5>

                            <p class="text-success font-weight-bold mb-1">
                                ${{ number_format($item->product->price, 2) }}
                            </p>

                            <p class="text-secondary small mb-1">
                                Quantity: {{ $item->quantity }}
                            </p>

                            <div class="d-flex justify-content-center gap-2 mt-2">
                                <!-- quantity input (same style) -->
                                    <input 
                                        type="number" 
                                        name="quantity" 
                                        value="{{ $item->quantity }}" 
                                        min="1" 
                                        class="form-control form-control-sm"
                                        style="width: 60px;"
                                    >
                                <!-- ORDER NOW BUTTON (MODAL TRIGGER) -->
                                <button 
                                    type="button"
                                    class="btn btn-success btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#checkoutModal{{ $item->id }}">
                                    Order Now
                                </button>

                                <!-- REMOVE -->
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

                <!-- 🔥 CHECKOUT MODAL -->
                <div class="modal fade" id="checkoutModal{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <form action="{{ route('order.store') }}" method="POST">
                                @csrf

                                <input type="hidden" name="cart_item_id" value="{{ $item->id }}">

                                <div class="modal-header">
                                    <h5 class="modal-title">Checkout</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="mb-2">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="customer_name" class="form-control" required>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Address</label>
                                        <textarea name="address" class="form-control" required></textarea>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" required>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Payment Method</label>
                                        <select name="payment_method" class="form-control" required>
                                            <option value="GCash">GCash</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                            <option value="Cash on Delivery">Cash on Delivery</option>
                                        </select>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Quantity</label>
                                        <input 
                                            type="number" 
                                            name="quantity" 
                                            value="{{ $item->quantity }}" 
                                            min="1" 
                                            class="form-control">
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button class="btn btn-success">
                                        Confirm Order
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <!-- 🔥 END MODAL -->

                @endforeach

            </div>
        @endif

    </div>
</section>
@endsection
