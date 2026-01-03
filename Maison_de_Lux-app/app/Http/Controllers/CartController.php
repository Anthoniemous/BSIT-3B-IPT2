<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService) //Aron ma-achieve ang Separation of Concerns. Ang Controller igo ra mo-handle sa request ug response, samtang ang 'business logic' (sama sa pag-calculate sa cart o pag-save og XML) gibalhin sa Service para mas limpyo ang code ug dali ma-reuse.
    {
        $this->cartService = $cartService;
    }

    // Display the user's cart
    public function show()
{
    $cartItems = $this->cartService->getUserCart(auth()->id());

    // Compute total
    $total = $cartItems->sum(function($item) {
        return $item->product->price * $item->quantity;
    });

    return view('user.cart.show', compact('cartItems', 'total'));
}

    // Add product to cart
    public function add($productId, Request $request)
    {
        $quantity = $request->input('quantity', 1);
        $this->cartService->addToCart(auth()->id(), $productId, $quantity);

        return redirect()->route('cart')->with('success', 'Product added to cart!');
    }

    // Update cart item quantity
    public function update($cartId, Request $request)
    {
        $quantity = $request->input('quantity', 1);
        $this->cartService->updateCartItem($cartId, $quantity);

        return redirect()->route('cart')->with('success', 'Cart updated!');
    }

    // Remove item from cart
    public function remove($cartId)
    {
        $this->cartService->removeCartItem($cartId);

        return redirect()->route('cart')->with('success', 'Item removed!');
    }

    // Checkout page
    public function checkout(Request $request)
{
    $userId = Auth::id();
    $cartItems = Cart::with('product')->where('user_id', $userId)->get();

    // Calculate total
    $total = 0;
    foreach ($cartItems as $item) {
        $total += $item->quantity * $item->product->price;
    }

    // Or using collection sum:
    // $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

    $selectedItems = $request->input('selected_items', []);

    return view('user.cart.checkout', compact('cartItems', 'total', 'selectedItems'));
}

    // Process checkout
    public function processCheckout(Request $request)
    {
        $this->cartService->checkout(auth()->id(), $request->all());
        return redirect()->route('myorders')->with('success', 'Order placed successfully!');
    }
}
