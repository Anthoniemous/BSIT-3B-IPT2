<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // 🔹 IMPORTANT: Your primary key is 'order_id', not 'id'
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'contact_number',
        'status',
        'total_price',
    ];

    // 🔹 Order has many order items
    // FIXED: Since your primary key is 'order_id', specify it explicitly
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    // 🔹 Order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}