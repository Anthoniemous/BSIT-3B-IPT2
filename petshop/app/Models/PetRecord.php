<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'vaccination_history_id',
        'pet_id',
        'number_of_vaccination',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function vaccinationHistory()
    {
        return $this->belongsTo(VaccinationHistory::class);
    }
}