<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        return view('wishlist.index');
    }

    public function add($id)
    {
        // Get product using your real primary key
        $product = Product::where('product_id', $id)->first();

        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        // Load wishlist session
        $wishlist = session()->get('wishlist', []);

        // Store correct product info
        $wishlist[$id] = [
            'id' => $product->product_id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image ?? null,
        ];

        // Save
        session()->put('wishlist', $wishlist);

        return back()->with('success', 'Added to wishlist!');
    }

    public function remove($id)
    {
        $wishlist = session()->get('wishlist', []);

        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
            session()->put('wishlist', $wishlist);
        }

        return back()->with('success', 'Removed from wishlist');
    }

    public function moveToCart($id)
    {
        $wishlist = session()->get('wishlist', []);
        $cart = session()->get('cart', []);

        if (isset($wishlist[$id])) {
            $cart[$id] = $wishlist[$id];

            // Remove from wishlist
            unset($wishlist[$id]);

            session()->put('cart', $cart);
            session()->put('wishlist', $wishlist);
        }

        return back()->with('success', 'Moved to cart');
    }
}
