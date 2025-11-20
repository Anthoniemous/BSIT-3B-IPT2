<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id'; // if your migration used product_id
    public $incrementing = true;
    protected $fillable = [
        'product_name',
        'description',
        'price',
        'image',
        'quantity',
        'category',
    ];

    public function carts()
{
    return $this->hasMany(Cart::class);
}
}
