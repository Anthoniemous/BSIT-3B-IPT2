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
        'size',
        'sizes',
        'image',
        'quantity',
        'category',
    ];

    protected $casts = [
        'sizes' => 'array',
    ];

    // ✅ ADD THIS METHOD - Tells Laravel to use product_id for routes
   public function getRouteKeyName()
{
    return 'product_id';
}

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id', 'product_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_id', 'product_id');
    }
}