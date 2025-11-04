<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traits extends Model
{
    use HasFactory;

    protected $fillable = ['description'];

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}