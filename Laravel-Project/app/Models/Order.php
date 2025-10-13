<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
     protected $primaryKey = 'order_id';
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'contact_number',
        'status',
        'total_price',
    ];

    // 🔹 Relationship to order_items
    public function items()
    {
           return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}
