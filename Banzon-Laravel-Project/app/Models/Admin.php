<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin'; // singular table name

   protected $fillable = [
    'name',
    'email',
    'password',
    'google_id',
];


    protected $hidden = [
        'password',
        'remember_token',
    ];
}
