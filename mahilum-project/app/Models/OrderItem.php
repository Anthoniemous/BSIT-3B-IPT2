<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // 🔹 Relationship to Order
    // FIXED: Explicitly specify that it connects to Order's 'order_id' primary key
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
        //                                     ^^^^^^^^^  ^^^^^^^^^
        //                                     foreign    owner key
        //                                     key in     (Order's
        //                                     this table primary key)
    }

    // 🔹 Relationship to Product
    public function product()
    {
       return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}