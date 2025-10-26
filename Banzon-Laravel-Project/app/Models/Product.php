<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product'; // table name in DB
    protected $primaryKey = 'product_id';
    public $timestamps = false; // no updated_at, created_at from Laravel defaults

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'status',
        'updated_by'
    ];
}
