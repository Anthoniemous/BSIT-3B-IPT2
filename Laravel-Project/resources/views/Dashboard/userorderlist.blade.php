<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders 🧾</title>
    <link rel="stylesheet" href="{{ asset('css/orderlist.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Header Start -->
<header class="site-header">
    <div class="header-inner">
        <div class="logo">
            <img src="{{ asset('css/img/logo.jpg') }}" alt="NBA Logo">
            <span class="brand">NBA Fan Store</span>
        </div>

        <nav class="main-nav">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
            </ul>
        </nav>

        <div class="user-option">
            @auth
                <a href="{{ route('orders.index') }}" class="btn small"> ORDERS</a>
                <a href="{{ route('cart.index') }}" class="btn small"> CART </a>

                <div class="profile-container">
                    <img 
                        src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('css/img/default-avatar.png') }}" 
                        alt="Profile" 
                        class="profile-pic" 
                        id="profileDropdownToggle"
                    >

                    <div class="dropdown-menu" id="profileDropdownMenu">
                        <h4>Welcome, {{ Auth::user()->name }}!</h4>

                        <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="profile_photo" required>
                            <button type="submit">Update Photo</button>
                        </form>

                        @if(session('success'))
                            <div class="alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="margin-top: 10px; background: #dc3545;">Logout</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>

<div class="container mt-4">
    <h1 class="page-title text-center mb-4">Your Orders 🧾</h1>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <!-- Orders Table -->
    <div class="order-table table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light text-white">
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
                @forelse($orders as $order)
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $order->order_id }}</td>
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
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-container text-center mt-3">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>

    <!-- Back to Dashboard -->
    <div class="mt-4 text-center">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>

    </div>
</div>

<!-- Auto-hide flash messages -->
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
