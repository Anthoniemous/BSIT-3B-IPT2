<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🧾 Orders</title>
    <link rel="stylesheet" href="{{ asset('css/orderlist.css') }}">

</head>
<body>

  <header class="site-header">
    <div class="container header-inner">
      <div class="logo">
        <img src="{{ asset('css/img/logo.png') }}" alt="Shampoo Logo">
        <span class="brand">Green Glow Shampoo Shop</span>
      </div>

     <nav class="main-nav">
        <ul>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('/userdashboard') }}">Products</a></li>
        </ul>
      </nav>

      <div class="user-option">
        @auth
        <a href="{{ route('wishlist.index') }}" class="btn small wishlist-btn">
          Wishlist
        </a>
        <a href="{{ route('orders.index') }}" class="btn small">Purchase History</a>
        <a href="{{ route('cart.index') }}" class="btn small">Your Shampoo Picks</a>

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

<div class="container">
    <h1 class="page-title">🧾 Orders</h1>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Check if user has orders --}}
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
                        <th>Actions</th>
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

                        // Check if order can be cancelled (only pending or processing)
                        $canCancel = in_array(strtolower($order->status), ['pending', 'processing']);
                    @endphp

                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>{{ $productNames }}</td>
                       @php
                        $totalQty = $order->items->sum('quantity');
                        @endphp
                        <td>{{ $totalQty }}</td>
                        <td>₱{{ number_format($totalAmount, 2) }}</td>
                        <td>
                            <span class="status {{ strtolower($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            @if($canCancel)
                                <button 
                                    class="action-btn btn-cancel" 
                                    onclick="showCancelModal({{ $order->order_id }}, '{{ $productNames }}', '{{ number_format($totalAmount, 2) }}')"
                                >
                                    Cancel Order
                                </button>
                            @else
                                <button class="action-btn btn-disabled" disabled>
                                    @if(strtolower($order->status) == 'cancelled')
                                        Cancelled
                                    @elseif(strtolower($order->status) == 'completed')
                                        Completed
                                    @else
                                        Not Available
                                    @endif
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    @endif

    <div class="mt-6 text-center">
        <a href="{{ url('/userdashboard') }}" class="nav-btn">
            ← Back to Dashboard
        </a>
    </div>

</div>

<!-- Cancel Order Modal -->
<div id="cancelModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>⚠️ Cancel Order</h2>
            <button class="modal-close" onclick="closeCancelModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to cancel this order?</p>
            <div class="order-details">
                <p><strong>Order ID:</strong> <span id="modalOrderId"></span></p>
                <p><strong>Products:</strong> <span id="modalProducts"></span></p>
                <p><strong>Total Amount:</strong> ₱<span id="modalAmount"></span></p>
            </div>
            <p><strong>This action cannot be undone.</strong></p>
        </div>
        <div class="modal-footer">
            <button class="btn-modal btn-modal-cancel" onclick="closeCancelModal()">
                No, Keep Order
            </button>
            <form id="cancelForm" method="POST" style="display: inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-modal btn-modal-confirm">
                    Yes, Cancel Order
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Show cancel modal
    function showCancelModal(orderId, products, amount) {
        document.getElementById('modalOrderId').textContent = orderId;
        document.getElementById('modalProducts').textContent = products;
        document.getElementById('modalAmount').textContent = amount;
        
        // Set form action
        const form = document.getElementById('cancelForm');
        form.action = `/orders/${orderId}/cancel`;
        
        // Show modal
        document.getElementById('cancelModal').classList.add('show');
    }

    // Close cancel modal
    function closeCancelModal() {
        document.getElementById('cancelModal').classList.remove('show');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('cancelModal');
        if (event.target === modal) {
            closeCancelModal();
        }
    }

document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("profileDropdownToggle");
    const menu = document.getElementById("profileDropdownMenu");

    toggle.addEventListener("click", function (e) {
        e.stopPropagation();
        menu.classList.toggle("active");
    });

    // close when clicking outside
    document.addEventListener("click", function () {
        menu.classList.remove("active");
    });
});
</script>

</body>
</html>