<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class TrendingProducts extends Model
{
    protected $table      = 'trending_products';
    public    $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'product_id',
        'priority',
    ];

}
