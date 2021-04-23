<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'product_id','user_id',
    ];
    #get products
    public function getProduct()
    {
        return $this->belongsTo('App\models\Products','product_id');
    }
}
