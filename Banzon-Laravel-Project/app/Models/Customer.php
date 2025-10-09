<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'customer'; // singular table name
    protected $primaryKey = 'customer_id';

    // Let Eloquent manage created_at/updated_at (recommended) 
    public $timestamps = true;

    protected $fillable = [
    'first_name', 
    'last_name', 
    'name', // optional duplicate full name you already have 
    'email', 
    'password', 
    'google_id', 
    'phone', 
    'address',
];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthPassword()
{
    return $this->customer_password;
}   
}



