<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class PromoCodes extends Model
{
    protected $table = 'promo_codes';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'promocode',
        'desciption',
        'image',
        'discount_amount',
        'discount_in'
    ]; 
}
