<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <link rel="stylesheet" href="{{ asset('css/orderlist.css') }}">
</head>
<body>

<!-- 🎨 SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-header">
        <h2>Admin Panel</h2>
        <p>Order Management</p>
    </div>
    
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <span class="icon">📊</span>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="nav-item">
            <span class="icon">📦</span>
            <span>Add Products</span>
        </a>
        <a href="{{ route('admin.orders.index') }}" class="nav-item active">
            <span class="icon">🛒</span>
            <span>View Orders</span>
        </a>
        
        <form action="{{ route('logout') }}" method="POST" class="sidebar-logout-inline">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </nav>
</div>

<!-- 📄 MAIN CONTENT -->
<div class="main-content">
    <!-- HEADER -->
   <div class="header-box">
    <h1>Order Dashboard</h1>
    <p>Manage and track all customer orders</p>
</div>

    <!-- SEARCH & FILTERS -->
    <div class="filter-section">
        <input type="text" placeholder="Search orders..." class="search-input">
        <select class="filter-select">
            <option>All Status</option>
            <option>Pending</option>
            <option>Processing</option>
            <option>Completed</option>
            <option>Cancelled</option>
        </select>
        <select class="filter-select">
            <option>Sort By Date</option>
            <option>Sort By Price</option>
        </select>
    </div>

    <!-- SUCCESS ALERT -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- ORDERS TABLE -->
    <div class="table-container">
        <table class="orders-table">
            <thead>
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
                            <ul class="product-list">
                                @foreach($order->items as $item)
                                    <li>{{ $item->product->product_name }} ({{ $item->size ?? 'N/A' }}) x {{ $item->quantity }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $order->items->sum('quantity') }}</td>
                        <td>₱{{ number_format($order->items->sum(fn($i) => $i->product->price * $i->quantity), 2) }}</td>
                        <td>
                            <span class="badge badge-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="status-form">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="status-select">
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
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="no-data">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

            <!-- PAGINATION -->
    <div class="pagination-container">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>  
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Auto-hide success alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 600);
        }, 4000);
    });
});
</script>
</body>
</html>