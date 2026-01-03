<x-app-layout>
   <link rel="stylesheet" href="{{ asset('assets/css/myorders.css') }}">

    <div class="orders-container">
        <div class="mb-6">
            <a href="{{ route('shop') }}" class="back-link">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Continue Shopping
            </a>
        </div>

        <h1 class="orders-title">My Orders</h1>

        @if(session('success'))
            <div class="alert alert-success mb-4" style="background: var(--accent-green); color: var(--gold); padding: 1rem; border-radius: 0.5rem; border: 1px solid var(--gold);">
                {{ session('success') }}
            </div>
        @endif

        @if($orders->count() > 0)
            @foreach($orders as $index => $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-id">Order #{{ $index + 1 }}</div>
                        <div class="order-status status-{{ strtolower($order->status ?? 'pending') }}">
                            {{ $order->status ?? 'Pending' }}
                        </div>
                    </div>
                    <div class="order-details">
                        <div class="order-item">
                            <span>Date:</span>
                            <span>{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="order-item">
                            <span>Total:</span>
                            <span>₱{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        @if($order->shipping_address)
                            <div class="order-item">
                                <span>Shipping Address:</span>
                                <span>{{ $order->shipping_address }}</span>
                            </div>
                        @endif
                        @if($order->phone)
                            <div class="order-item">
                                <span>Phone:</span>
                                <span>{{ $order->phone }}</span>
                            </div>
                        @endif
                        @if($order->orderItems->count() > 0)
                            <div class="order-item">
                                <span>Items:</span>
                                <span>
                                    @foreach($order->orderItems as $item)
                                        {{ $item->product->product_name ?? 'Product' }} (x{{ $item->quantity }})
                                        @if(!$loop->last), @endif
                                    @endforeach
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="order-total">
                        <div class="order-item">
                            <span>Items Count:</span>
                            <span>{{ $order->orderItems->count() }} item(s)</span>
                        </div>
                    @if(strtolower($order->status ?? 'pending') === 'pending')
                        
                            <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order? This will restore the product stock.')" style="display: inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn-cancel">
                                    Cancel Order
                                </button>
                            </form>
                        </div>
                    @elseif(strtolower($order->status ?? 'pending') === 'cancelled')
                        <div class="mt-4">
                            <form action="{{ route('orders.delete', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this cancelled order? This action cannot be undone.')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-cancel" style="background: #6c757d;">
                                    Delete Order
                                </button>
                            </form>
                        </div>
                    @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-orders">
                <p>You haven't placed any orders yet.</p>
                <p><a href="{{ route('shop') }}" class="back-link">Start shopping now!</a></p>
            </div>
        @endif
    </div>
</x-app-layout>
