<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="site-header">
  <div class="header-inner">
      <div class="logo">
        <img src="{{ asset('css/img/logo.jpg') }}" alt="NBA Logo">
        <span class="brand">NBA Fan Store</span>
      </div>

      <nav class="main-nav">
        <ul>
          <li><a href="{{ url('/userdashboard') }}">Shop</a></li>
          <li><a href="{{ route('orders.index') }}">Orders</a></li>
          <li><a href="{{ route('cart.index') }}" style="font-weight:bold;">Cart</a></li>
          <li><a href="{{ route('wishlist.index') }}">Wishlist</a></li>
        </ul>
      </nav>
  </div>
</header>

<div class="container mt-4">
    <h1 class="text-center mb-4">Cart 🛒</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-red-gradient">
                <tr>
                    <th>Select</th>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="cart-body">
            @forelse($cartItems as $item)
                <tr 
                    data-cart-id="{{ $item->cart_id }}"
                    data-price="{{ $item->product->price }}"
                    data-stock="{{ $item->product->quantity }}"
                >
                    <td>
                        <input type="checkbox" class="select-item" checked>
                    </td>

                    <td>{{ $item->product->product_name }}</td>

                    <td>{{ $item->size ?? 'N/A' }}</td>

                    <td>{{ $item->product->brand }}</td>

                    <td>
                        <div class="quantity-control">
                            <button class="btn btn-sm btn-secondary"
                                onclick="changeQuantity(this,-1)">-</button>

                            <input type="text" class="quantity-input" 
                                   value="{{ $item->quantity }}" readonly>

                            <button class="btn btn-sm btn-secondary"
                                onclick="changeQuantity(this,1)"
                                {{ $item->quantity >= $item->product->quantity ? 'disabled' : '' }}>
                                +
                            </button>
                        </div>

                        <small class="text-muted">
                            Stock left: {{ $item->product->quantity }}
                        </small>
                    </td>

                    <td class="item-total">
                        ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                    </td>

                    <td>
                        <form method="POST" action="{{ route('cart.remove',$item->cart_id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Your cart is empty</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="text-end mt-3">
        <h4>Total: <span id="grand-total">₱0.00</span></h4>

        <form method="POST" action="{{ route('cart.checkout') }}">
            @csrf
            <input type="hidden" name="cart_ids" id="cart-ids">
            <button class="btn btn-success btn-lg">Checkout</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("profileDropdownToggle");
    const menu = document.getElementById("profileDropdownMenu");

    if (!toggle || !menu) return;

    toggle.addEventListener("click", function (e) {
        e.stopPropagation();
        menu.classList.toggle("active");
    });

    document.addEventListener("click", function (e) {
        if (!menu.contains(e.target) && !toggle.contains(e.target)) {
            menu.classList.remove("active");
        }
    });

    menu.addEventListener("click", function (e) {
        e.stopPropagation();
    });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            menu.classList.remove("active");
        }
    });
});
document.addEventListener("DOMContentLoaded", updateGrandTotal);

function changeQuantity(btn, delta) {
    const row = btn.closest("tr");
    const input = row.querySelector(".quantity-input");
    const stock = parseInt(row.dataset.stock);

    let qty = parseInt(input.value) + delta;
    if (qty < 1) qty = 1;
    if (qty > stock) {
        alert("Not enough stock available");
        return;
    }

    input.value = qty;

    const price = parseFloat(row.dataset.price);
    row.querySelector(".item-total").innerText =
        "₱" + (price * qty).toFixed(2);

    updateCartQuantity(row.dataset.cartId, qty);
    updateGrandTotal();
}

function updateGrandTotal() {
    let total = 0;
    let ids = [];

    document.querySelectorAll("#cart-body tr").forEach(row => {
        if (row.querySelector(".select-item")?.checked) {
            total += parseFloat(
                row.querySelector(".item-total")
                .innerText.replace("₱","")
            );
            ids.push(row.dataset.cartId);
        }
    });

    document.getElementById("grand-total").innerText =
        "₱" + total.toFixed(2);

    document.getElementById("cart-ids").value = ids.join(",");
}

function updateCartQuantity(cartId, quantity) {
    fetch(`/cart/update/${cartId}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ quantity })
    });
}
</script>

</body>
</html>
