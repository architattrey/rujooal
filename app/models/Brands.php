<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    protected $table = 'brands';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'cat_id',
        'brand_name',
        'delete_status',
    ];
    public function categoryBrands()
    {
        return $this->belongsTo('App\models\Category','cat_id');
    }  
}
