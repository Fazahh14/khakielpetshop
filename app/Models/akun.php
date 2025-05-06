<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Akun extends Authenticatable
{
    use Notifiable;

    protected $table = 'akun';

    protected $fillable = [
        'nama', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
