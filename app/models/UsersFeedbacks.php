<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UsersFeedbacks extends Model
{
    protected $table = 'users_feedbacks';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'product_id',
        'feedbacks',
        'created_at',
        'updated_at',
    ];
    public function feedbackProducts()
    {
        return $this->belongsTo('App\models\products','product_id');
    }  
}
