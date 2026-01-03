<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // Show all wishlist items
    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('product')->get();
        return view('wishlist.index', compact('wishlists'));
    }
    
    // Add product to wishlist
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id'
        ]);
        
        try {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist'
            ], 422);
        }
    }
    
    // Remove product from wishlist
    public function destroy($productId)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
                           ->where('product_id', $productId)
                           ->first();
        
        if ($wishlist) {
            $wishlist->delete();
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from wishlist'
                ]);
            }
            
            return redirect()->back()->with('success', 'Product removed from wishlist');
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Product not found in wishlist'
        ], 404);
    }
    
    // Move product from wishlist to cart
    public function moveToCart($productId)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
                           ->where('product_id', $productId)
                           ->first();
        
        if (!$wishlist) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in wishlist'
            ], 404);
        }
        
        try {
            // Add to cart
            Cart::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'product_id' => $productId
                ],
                [
                    'quantity' => 1
                ]
            );
            
            // Remove from wishlist
            $wishlist->delete();
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product moved to cart'
                ]);
            }
            
            return redirect()->back()->with('success', 'Product moved to cart');
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to move product to cart'
            ], 500);
        }
    }
}