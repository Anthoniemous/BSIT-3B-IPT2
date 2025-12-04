<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Order List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/userorderlist.css') }}" /> <!-- reuse cart.css -->
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <div class="logo">
                <img src="{{ asset('css/img/logo.jpg') }}" alt="NBA Logo" />
                <span class="brand">NBA Fan Store</span>
            </div>

            <nav class="main-nav">
                <ul>
                    <li><a href="{{ url('/') }}" style="font-weight: bold;">Home</a></li>
                    <li><a href="{{ url('/userdashboard') }}">Shop</a></li>
                    <li><a href="{{ route('orders.index') }}" style="font-weight: bold;">Orders</a></li>
                    <li><a href="{{ route('cart.index') }}" style="font-weight: bold;">Cart</a></li>
                    <li><a href="{{ route('wishlist.index') }}" style="font-weight: bold;">Wishlist</a></li>
                </ul>
            </nav>

            <div class="user-option">
                @auth
                    <div class="profile-container">
                        <img
                            src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('css/img/default-avatar.png') }}"
                            alt="Profile"
                            class="profile-pic"
                            id="profileDropdownToggle"
                        />
                        <div class="dropdown-menu" id="profileDropdownMenu">
                            <h4>Welcome, {{ Auth::user()->name }}!</h4>
                            <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="profile_photo" required />
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
    <h1 class="page-title text-center mb-4">Order List</h1>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="success-message">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert" id="error-message">
            {{ session('error') }}
        </div>
    @endif

    <!-- Orders Table -->
    <div class="order-table table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Products</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="text-start">
                            <ul class="mb-0 ps-3">
                                @foreach($order->items as $item)
                                    <li>
                                        {{ $item->product->product_name }} 
                                        ({{ $item->size ?? 'N/A' }}) 
                                        - {{ $item->quantity }} × ₱{{ number_format($item->product->price,2) }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            ₱{{ number_format($order->items->sum(fn($i) => $i->quantity * $i->product->price),2) }}
                        </td>
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

    <!-- Back to Dashboard -->
    <div class="mt-4 text-center">
        <a href="{{ route('user.dashboard') }}" 
        class="btn btn-primary px-4 py-2">Back to Dashboard</a>
    </div>
</div>

<!-- Auto-hide flash message -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const success = document.getElementById("success-message");
        const error = document.getElementById("error-message");

        if (success) {
            setTimeout(() => {
                success.classList.add("fade");
                setTimeout(() => success.style.display = "none", 600);
            }, 4000);
        }

        if (error) {
            setTimeout(() => {
                error.classList.add("fade");
                setTimeout(() => error.style.display = "none", 600);
            }, 4000);
        }
    });
</script>
</body>
</html>
