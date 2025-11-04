<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $table = 'customer';
    protected $primaryKey = 'customer_id';
    public $timestamps = true;

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'google_id',
        'phone',
        'address',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
