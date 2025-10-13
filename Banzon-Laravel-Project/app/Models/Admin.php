<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin'; // exact table name
    protected $primaryKey = 'admin_id'; 
    public $timestamps = false; // disable created_at and updated_at

    protected $fillable = [
        'username',
        'email',
        'password',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
