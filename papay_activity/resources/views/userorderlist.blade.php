<x-app-layout>

<link rel="stylesheet" href="{{ asset('css/orderlist.css') }}">

<div class="container">
    <h1 class="page-title">Customer Vape Orders 💨</h1>

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
    @if($orders->isEmpty())
        <p class="no-orders">You haven't placed any vape orders yet.</p>
    @else
        <div class="order-table">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Delivery Address</th>
                        <th>Contact Number</th>
                        <th>Order Date</th>
                        <th>Vape Product</th>
                        <th>Quantity</th>
                        <th>Total Price</th>  
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $order->order_id }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->contact_number }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>{{ $item->product->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
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
    @endif

    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Back to Vape Dashboard</a>
    </div>

</div>
</x-app-layout>
