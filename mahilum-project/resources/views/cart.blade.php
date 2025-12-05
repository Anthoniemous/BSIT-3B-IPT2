<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Cart</title>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
<body>

<div class="container">
    <h1 class="page-title">☕ Your Coffee Cart</h1>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <p class="no-orders">☕ Your cart is empty, coffee lover! Add some brews to get started.</p>
    @else
        <!-- CART TABLE -->
        <div class="order-table">
            <table id="cart-table">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Brew</th>
                        <th>Cups</th>
                        <th>Total</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr data-price="{{ $item->product->price }}" data-cartid="{{ $item->cart_id }}">
                        <td><input type="checkbox" class="select-item" checked></td>

                        <td>{{ $item->product->product_name ?? 'Unknown Coffee' }}</td>

                        <td>
                            <div class="qty-wrapper">
                                <button class="qty-btn minus">-</button>
                                <input type="number" class="qty-input" value="{{ $item->quantity }}" min="1">
                                <button class="qty-btn plus">+</button>
                            </div>
                        </td>

                        <td class="item-total">₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>

                        <td>
                            <div class="actions">
                                <form method="POST" action="{{ route('cart.remove', $item->cart_id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn danger">🗑️ Remove</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- GRAND TOTAL + CHECKOUT (RIGHT SIDE) -->
        <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
            <div style="text-align: right;">
                <div class="grand-total-box" style="font-size: 22px; margin-bottom: 10px;">
                     Totals: <span id="grandTotal">₱0.00</span>
                </div>

                <form id="checkoutForm" method="GET" action="{{ route('orders.checkoutPage') }}">
                    <div id="selectedItemsContainer"></div>
                    <button type="submit" class="btn primary big-checkout">☕ Checkout Items</button>
                </form>
            </div>
        </div>

    @endif

    <div class="mt-6 text-center">
        <a href="{{ route('user.dashboard') }}" class="nav-btn">← Back to Dashboard</a>
        <a href="{{ route('orders.index') }}" class="nav-btn ml-3">View My Orders</a>
    </div>
</div>

<!-- JAVASCRIPT FUNCTION -->
<script>
document.addEventListener("DOMContentLoaded", () => {

    const updateTotals = () => {
        let grandTotal = 0;
        let selected = [];
        const container = document.getElementById("selectedItemsContainer");

        document.querySelectorAll("#cart-table tbody tr").forEach(row => {
            const price = parseFloat(row.dataset.price);
            const qty = parseInt(row.querySelector(".qty-input").value);
            const checkbox = row.querySelector(".select-item");
            const totalCell = row.querySelector(".item-total");
            const cartId = row.dataset.cartid;

            const itemTotal = price * qty;
            totalCell.textContent = "₱" + itemTotal.toFixed(2);

            if (checkbox.checked) {
                grandTotal += itemTotal;
                selected.push(cartId);
            }
        });

        document.getElementById("grandTotal").textContent = "₱" + grandTotal.toFixed(2);

        container.innerHTML = "";
        selected.forEach(id => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "selected_items[]";
            input.value = id;
            container.appendChild(input);
        });
    };

    document.querySelectorAll(".qty-wrapper").forEach(wrapper => {
        const input = wrapper.querySelector(".qty-input");

        wrapper.querySelector(".plus").addEventListener("click", () => {
            input.value = parseInt(input.value) + 1;
            updateTotals();
        });

        wrapper.querySelector(".minus").addEventListener("click", () => {
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;
            }
            updateTotals();
        });
    });

    document.querySelectorAll(".qty-input, .select-item")
        .forEach(el => el.addEventListener("change", updateTotals));

    updateTotals();
});
</script>

</body>
</html>
