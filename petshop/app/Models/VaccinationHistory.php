<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'vaccine_type',
        'vaccination_date',
    ];

    protected $casts = [
        'vaccination_date' => 'date',
    ];

    public function petRecords()
    {
        return $this->hasMany(PetRecord::class);
    }
}