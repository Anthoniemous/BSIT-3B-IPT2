<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Columns nga pwede i-fill sa mass assignment
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Password auto hidden
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Type casting sa columns
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
