<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'category',
        'price',
        'stock_quantity',
        'description',
        'user_id',
        'product_image',
        'brand' // Add this if you want brand filtering
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Wishlist relationship
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_id', 'product_id');
    }

    // Cart relationship
    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id', 'product_id');
    }

    // Optional: Check if product is in user's wishlist
    public function isInWishlist($userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $this->wishlists()->where('user_id', $userId)->exists();
    }

    // Optional: Check if product is in user's cart
    public function isInCart($userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $this->carts()->where('user_id', $userId)->exists();
    }

    // Optional: Scope for filtering by category
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Optional: Scope for filtering by brand
    public function scopeByBrand($query, $brand)
    {
        return $query->where('brand', $brand);
    }

    // Optional: Scope for filtering by price range
    public function scopePriceRange($query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
        return $query;
    }
    public function transactions()
{
    return $this->hasMany(Transaction::class, 'product_id');
}
}