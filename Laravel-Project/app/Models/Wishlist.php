<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    // Relationship: Wishlist belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Wishlist belongs to Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
        // or if your Product primary key is 'id', then use:
        // return $this->belongsTo(Product::class);
    }
}
