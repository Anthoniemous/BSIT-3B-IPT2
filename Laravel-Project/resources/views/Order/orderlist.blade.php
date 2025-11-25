<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Order List  </title>
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

<div class="container">
    <h1 class="page-title">Order List</h1>

    <!-- ✅ Flash Messages -->
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
    <div class="order-table">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Size</th>       
                    <th>Brand</th>      
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
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>{{ $item->product->product_name }}</td>
                            <td>{{ $item->size ?? 'N/A' }}</td>      <!-- Adjust as needed -->
                            <td>{{ $item->product->brand ?? 'Unknown Brand' }}</td>
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

    <!-- Pagination -->
    <div class="pagination-container text-center">
        <p class="pagination-info mb-2">Showing 1 to 2 of 2 results</p>
        <nav class="pagination-links d-inline-block">
            <ul class="pagination justify-content-center mb-0">
                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>

    <!-- Back to Dashboard -->
    <div class="mt-6 text-center">
        <a href="{{ route('user.dashboard') }}" 
        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg shadow-md transition duration-200 ease-in-out">
            Back to Dashboard
        </a>
    </div>
</div>

<!-- ✅ Auto-hide flash message -->
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
