<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UsersDeliveryAddress extends Model
{
    protected $table = 'users_delivery_addresses';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'dlvry_address',
        'created_at',
        'updated_at',
    ];
}
