<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'photoUrl',
        'role',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public $timestamps = false;
    protected $primaryKey = 'user_id';
    protected $keyType = 'int';
    public $incrementing = true;
}
