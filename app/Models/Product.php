<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    
public function category()
{
    return $this->belongsTo(Category::class, 'category_id', 'category_id');
}


    // If your primary key is product_id:
    protected $primaryKey = 'product_id';

    // If the primary key is not incrementing integer, set $incrementing and $keyType accordingly.
    // protected $incrementing = true;
    // protected $keyType = 'int';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];
}
