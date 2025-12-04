<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <link rel="stylesheet" href="{{ asset('css/orderlist.css') }}">
</head>
<body>
<header class="dashboard-header">
    <div class="header-content">
        <div class="header-left">
            <h1>Admin Dashboard</h1>
        </div>
        <div class="header-buttons">
            <a href="{{ route('products.create') }}" class="btn">Add Product</a>
            <a href="{{ route('admin.orders') }}" class="btn">View All Orders</a>
            <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>
        </div>
        <div class="header-right">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout">Logout</button>
            </form>
        </div>
    </div>
</header>

<div class="container mt-4">
    <h1 class="page-title">Orders List</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="order-table table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Products</th>
                    <th>Total Quantity</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>{{ $order->name }}</td>
                        <td>
                            <ul style="list-style:none; padding-left:0;">
                                @foreach($order->items as $item)
                                    <li>{{ $item->product->product_name }} ({{ $item->size ?? 'N/A' }}) x {{ $item->quantity }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $order->items->sum('quantity') }}</td>
                        <td>₱{{ number_format($order->items->sum(fn($i) => $i->product->price * $i->quantity), 2) }}</td>
                        <td>
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()">
                                    <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                                    <option value="processing" {{ $order->status=='processing'?'selected':'' }}>Processing</option>
                                    <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.orders.remove', $order) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container text-center mt-3">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add("fade");
            setTimeout(() => alert.style.display = "none", 600);
        }, 4000);
    });
});
</script>
</body>
</html>
