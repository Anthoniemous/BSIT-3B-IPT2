<x-app-layout>

<link rel="stylesheet" href="{{ asset('css/orderlist.css') }}">

<div class="container">
    <h1 class="page-title">🧾 My Orders</h1>

    {{-- ✅ Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- ✅ Check if user has any orders --}}
    @if($orders->count() === 0)
        <p class="no-orders">You have no orders yet.</p>
    @else
        <div class="order-table">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        @foreach($order->items as $item)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>{{ $item->product->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                <td>
                                    <span class="status {{ strtolower($order->status) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ✅ Pagination --}}
        <div class="pagination-container">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif

    <div class="mt-6 text-center">
        <a href="{{ url('/userdashboard') }}" 
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg shadow-md transition duration-200 ease-in-out">
            Back to Dashboard
        </a>
    </div>

</div>
</x-app-layout>
