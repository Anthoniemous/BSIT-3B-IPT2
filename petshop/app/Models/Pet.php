<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'breed',
        'price',
        'quantity',
        'arrival_date',
        'trait_id',
        'species_id',
        'supplier_id',
        'image',
        'description',
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'price' => 'decimal:2',
    ];

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function trait()
    {
        return $this->belongsTo(Traits::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function petRecords()
    {
        return $this->hasMany(PetRecord::class);
    }

    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class);
    }
}
