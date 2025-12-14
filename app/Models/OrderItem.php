<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    // Relationship to product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relationship back to order (optional but useful)
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
