<x-app-layout>
   <link rel="stylesheet" href="{{ asset('assets/css/order-edit.css') }}">

    <div class="edit-container">
        <div class="mb-6">
            <a href="{{ route('myorders') }}" class="back-link">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to My Orders
            </a>
        </div>

        <h1 class="edit-title">Edit Order</h1>

        @if(session('success'))
            <div class="alert alert-success mb-4" style="background: var(--accent-green); color: var(--gold); padding: 1rem; border-radius: 0.5rem; border: 1px solid var(--gold);">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-4" style="background: #dc3545; color: var(--white); padding: 1rem; border-radius: 0.5rem; border: 1px solid #dc3545;">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="edit-card">
            <div class="order-header">
                <div class="order-id">Order #{{ $order->id }}</div>
                <div class="order-status">{{ $order->status }}</div>
            </div>

            <form action="{{ route('orders.update', $order) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" name="phone" id="phone" class="form-input" value="{{ old('phone', $order->phone) }}" required>
                </div>

                <div class="form-group">
                    <label for="shipping_address" class="form-label">Shipping Address</label>
                    <textarea name="shipping_address" id="shipping_address" class="form-input form-textarea" required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                </div>

                <div class="order-items">
                    <h3 style="color: var(--gold); font-family: 'Playfair Display', serif; margin-bottom: 1rem;">Order Items</h3>
                    @foreach($order->orderItems as $item)
                        <div class="order-item">
                            <span>{{ $item->product->product_name ?? 'Product' }} (x{{ $item->quantity }})</span>
                            <span>₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="order-total">
                    <div class="order-item">
                        <span>Total:</span>
                        <span>₱{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn-luxury">
                        Update Order
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </button>
                    <a href="{{ route('myorders') }}" class="btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
