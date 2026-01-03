<x-app-layout>
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">

    <div class="cart-container">
        <div class="mb-6">
            <a href="{{ route('shop') }}" class="back-link">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Continue Shopping
            </a>
        </div>

{{-- ✅ Laravel Success/Error Alerts --}}
@if(session('success'))
    <div class="p-3 mb-4 bg-green-500 text-white rounded">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="p-3 mb-4 bg-red-500 text-white rounded">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="p-3 mb-4 bg-red-500 text-white rounded">
        {{ $errors->first() }}
    </div>
@endif

        <h1 class="cart-title">Your Cart</h1>

        @if($cartItems->count() > 0)
            <form id="cart-form" action="{{ route('checkout') }}" method="GET">

                <!-- Select All Controls -->
                <div class="mb-4 flex items-center gap-4">
                    <label class="flex items-center gap-2 text-white">
                        <input type="checkbox" id="select-all" class="w-4 h-4 text-gold bg-dark-green border-gold rounded focus:ring-gold">
                        <span class="font-medium">Select All Items</span>
                    </label>
                </div>

                @foreach($cartItems as $item)
                    <div class="cart-item">
                        <div class="cart-item-checkbox">
                            <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="item-checkbox" checked>
                        </div>
                        <div class="cart-item-image">
                            @if($item->product->product_image)
                                <img src="{{ asset('storage/products/' . $item->product->product_image) }}" alt="{{ $item->product->product_name }}">
                            @else
                                <div class="w-full h-full bg-gray-600 flex items-center justify-center text-white text-sm">No Image</div>
                            @endif
                        </div>
                        <div class="cart-item-details">
                            <h3 class="cart-item-name">{{ $item->product->product_name }}</h3>
                            <p class="cart-item-category">{{ $item->product->category ?? 'N/A' }}</p>
                            <p class="cart-item-price">₱{{ number_format($item->product->price, 2) }}</p>
                        </div>
                        <div class="cart-item-quantity">
                            <input type="number" name="quantities[{{ $item->id }}]" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity }}" class="quantity-input">
                            <button type="button" class="btn-update" onclick="updateCartItem({{ $item->id }}, this.previousElementSibling.value)">Update</button>
                            <button type="button" class="btn-remove" onclick="removeCartItem({{ $item->id }})">Remove</button>
                        </div>
                    </div>
                @endforeach

                <!-- Cart Total and Checkout -->
                <div class="cart-total">
                    <p class="total-amount">Total: ₱{{ number_format($total, 2) }}</p>
                    <button type="submit" class="btn-checkout">Proceed to Checkout</button>
                </div>
            </form>
        @else
            <div class="empty-cart">
                <p>Your cart is empty.</p>
                <a href="{{ route('shop') }}" class="btn-checkout" style="display: inline-block; margin-top: 1rem;">Start Shopping</a>
            </div>
        @endif
    </div>

    <script>
        // Select All functionality
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Update individual checkboxes to affect select-all
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('item-checkbox')) {
                const allCheckboxes = document.querySelectorAll('.item-checkbox');
                const checkedCheckboxes = document.querySelectorAll('.item-checkbox:checked');
                const selectAllCheckbox = document.getElementById('select-all');

                selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length;
            }
        });

        function updateCartItem(cartId, quantity) {
            // Add update functionality if needed
            console.log('Update cart item:', cartId, quantity);
        }

        function removeCartItem(cartId) {
            if (confirm('Are you sure you want to remove this item from your cart?')) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/cart/remove/${cartId}`;

                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfToken);

                // Add method spoofing
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-app-layout>
