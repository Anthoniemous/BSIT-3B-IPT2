<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\User;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'status',
        'customer_name',
        'address',
        'phone',
        'payment_method'
    ];

    // Relationship to order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship to user (customer)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
