<x-app-layout>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Checkout</h1>

    @if(session('cart') && count(session('cart')) > 0)
        <p>You have {{ count(session('cart')) }} items in your cart.</p>
        <!-- Add checkout form here -->
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
</x-app-layout>
