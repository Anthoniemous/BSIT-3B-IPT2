<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'brand',
        'size', // single default size if needed
        'sizes', // JSON array of sizes
        'image',
        'quantity',
        'category',
    ];

    // Cast sizes JSON to array
    protected $casts = [
        'sizes' => 'array',
    ];

    // Relationship to Cart
    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id', 'product_id');
    }

    // Relationship to Wishlist
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_id', 'product_id');
    }
}
