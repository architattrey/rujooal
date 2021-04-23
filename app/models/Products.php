<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'cat_id',
        'brand_id',
        'products',
        'mrp',
        'big_basket_mrp',
        'rujooal_price',
        'weight',
        'unit',
        'product_image',
        'description',
        'stock',
        'delete_status',
        'created_at',
        'updated_at',
    ]; 
    #get cart products
    public function getCart()
    {
        return $this->hasMany('App\models\Cart','product_id','id');
    }
    #get trending products
    public function getTrendingProducts()
    {
        return $this->hasOne('App\models\TrendingProducts','product_id','id');

    }
    #feedbacks 
    public function getUsersFeedbacks()
    {
        return $this->hasOne('App\models\UsersFeedbacks','product_id','id');
    }

}
