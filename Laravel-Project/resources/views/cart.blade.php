<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart 🛒</title>
    <link rel="stylesheet" href="css/cart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="page-title">Cart 🛒</h1>

    <!-- ✅ Flash Messages -->
    @if(session('success'))
        <div id="flash-success" class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div id="flash-error" class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @else
        <!-- Hidden by default -->
        <div id="flash-success" class="alert alert-success text-center" style="display:none;">
            Item added to cart successfully!
        </div>
        <div id="flash-error" class="alert alert-danger text-center" style="display:none;">
            Something went wrong!
        </div>
    @endif

    <!-- 🛍 Cart Table -->
    <div id="cart-section">
        <div class="order-table">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="cart-body">
                    @foreach($cartItems as $item)
                        <tr>
                            <td>{{ $item->product->product_name ?? 'Unknown Product' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                            <td>
                                <div class="actions">
                                    <form method="POST" action="{{ route('cart.remove', $item->cart_id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>

                                    <form method="GET" action="{{ route('orders.order', ['cart_id' => $item->cart_id]) }}">
                                        <button type="submit" class="btn btn-primary">Checkout</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- No items message -->
    <p id="empty-cart" class="no-orders text-center" style="display:none;">No items in your cart.</p>

    <!-- 🔙 Navigation Buttons -->
    <div class="mt-6 text-center">
        <a href="{{ route('user.dashboard') }}" class="nav-btn">Back to Dashboard</a>
        <a href="{{ route('orders.index') }}" class="nav-btn ml-3">Go to Orders</a>
    </div>
</div>

<!-- ✅ JavaScript Functionalities -->
<script>
    // Hide flash messages automatically after 3 seconds
    document.addEventListener("DOMContentLoaded", function() {
        const flashSuccess = document.getElementById("flash-success");
        const flashError = document.getElementById("flash-error");

        [flashSuccess, flashError].forEach(flash => {
            if (flash && flash.style.display !== "none") {
                setTimeout(() => {
                    flash.classList.add("fade");
                    setTimeout(() => flash.style.display = "none", 600);
                }, 3000);
            }
        });
    });

    // Remove item dynamically
    function removeItem(button) {
        const row = button.closest("tr");
        row.remove();
        checkEmptyCart();
        showFlash('flash-success', 'Item removed successfully!');
    }

    // Checkout item dynamically
    function checkoutItem(button) {
        const row = button.closest("tr");
        const product = row.cells[0].innerText;
        showFlash('flash-success', `Successfully checked out: ${product}!`);
        row.remove();
        checkEmptyCart();
    }

    // Check if cart empty
    function checkEmptyCart() {
        const cartBody = document.getElementById("cart-body");
        if (cartBody && cartBody.rows.length === 0) {
            document.getElementById("cart-section").style.display = "none";
            document.getElementById("empty-cart").style.display = "block";
        }
    }

    // Flash message function
    function showFlash(id, message) {
        const flash = document.getElementById(id);
        flash.textContent = message;
        flash.style.display = "block";
        setTimeout(() => {
            flash.classList.add("fade");
            setTimeout(() => {
                flash.style.display = "none";
                flash.classList.remove("fade");
            }, 600);
        }, 3000);
    }
</script>
</body>
</html>
