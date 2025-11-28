<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders – Brew Haven Coffee</title>
    <link rel="stylesheet" href="{{ asset('css/userorderlist.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="container my-5">
        <h1 class="page-title text-center mb-4">Customer Orders 🧾</h1>

        {{-- ✅ Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        {{-- ✅ Check if user has any orders --}}
        @if($orders->isEmpty())
            <p class="no-orders text-center">You have no orders yet.</p>
        @else
            <div class="order-table table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Contact</th>
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

        <div class="mt-4 text-center">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
        </div>
    </div>

</body>
</html>
