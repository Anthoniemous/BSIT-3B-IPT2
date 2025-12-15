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

    // 🔹 Order has many items
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    // 🔹 Order belongs to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // ✅ ADD: total quantity (FIXED)
    public function totalQuantity()
    {
        return $this->items->sum('quantity');
    }

    // ✅ ADD: total amount (FIXED — uses item price)
    public function totalAmount()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }
}
