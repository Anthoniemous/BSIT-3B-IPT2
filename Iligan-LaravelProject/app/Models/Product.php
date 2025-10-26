<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // ✅ Explicitly define table name (optional but good practice)
    protected $table = 'products';

    // ✅ Set primary key to match your migration
    protected $primaryKey = 'product_id';

    // ✅ Optional, but keeps key behavior explicit
    public $incrementing = true;
    protected $keyType = 'int';

    // ✅ Mass assignable fields
    protected $fillable = [
        'category_id',
        'admin_id',
        'name',
        'description',
        'quantity',
        'unit_price',
        'image',
        'status', // <- include this because your controller uses it
    ];

    // ✅ Relationship to Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    // ✅ Relationship to Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
