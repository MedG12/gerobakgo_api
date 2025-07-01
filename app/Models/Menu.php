<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $table = 'menus'; // Assuming you have a menus table

    protected $fillable = [
        'merchant_id',
        'name',
        'description',
        'price',
        'photoUrl', 
    ];

    public $timestamps = false; // Assuming you don't want timestamps

    protected $primaryKey = 'menu_id'; // Assuming you have a primary key named menu_id
    protected $keyType = 'int';
    public $incrementing = true;

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'merchant_id');
    }

}
