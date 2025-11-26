<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Primary key
    protected $primaryKey = 'product_id';

    // Fillable fields
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'brand',
        'category', // ✅ Add this
    ];
}
