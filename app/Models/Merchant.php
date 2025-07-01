<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $table = 'merchants'; // Assuming you have a merchants table

    protected $fillable = [
        'user_id',
        'description',
        'openHour',
        'closeHour',
    ];

    public $timestamps = false; // Assuming you don't want timestamps

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'merchant_id', 'merchant_id');
    }

    protected $primaryKey = 'merchant_id';
    protected $keyType = 'int';
    public $incrementing = true;
}
