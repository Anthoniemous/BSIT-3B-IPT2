<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'user_id',
        'product_id',
        'transaction_date',
        'quantity',
        'price',
        'total_amount',
        'transaction_status'
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'price' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class, 'transaction_id');
    }
}