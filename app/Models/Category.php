<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Match your primary key name
    protected $primaryKey = 'category_id';

    // The table name (optional if it follows plural form)
    protected $table = 'categories';

    // Allow mass assignment for these columns
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Each category can have many products.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
