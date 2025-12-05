<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orderlist</title>
    <link rel="stylesheet" href="{{ asset('css/orderlist.css') }}">
</head>
<body>
    

<div class="container">
    <h1 class="page-title">Orders 🧾</h1>

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
                    @php
                        // Combine all product names into one string
                        $productNames = $order->items->map(function ($item) {
                            return $item->product->product_name;
                        })->unique()->join(', ');

                        // Total quantity
                        $totalQty = $order->items->sum('quantity');

                        // Total price for the order
                        $totalAmount = $order->items->sum(function ($item) {
                            return $item->quantity * $item->product->price;
                        });
                    @endphp

                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>{{ $productNames }}</td>
                        <td>{{ $totalQty }}</td>
                        <td>₱{{ number_format($totalAmount, 2) }}</td>
                        <td>
                            <span class="status {{ strtolower($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
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
        <a href="{{ route('user.dashboard') }}" 
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg shadow-md transition duration-200 ease-in-out">
            Back to Dashboard
        </a>
    </div>

</div>
</body>
</html>