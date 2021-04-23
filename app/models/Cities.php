<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table = 'cities';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'state_id',
        'cities',
        'created_at',
        'updated_at',
    ];
}
