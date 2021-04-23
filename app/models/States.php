<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    protected $table = 'states';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'states',
        'created_at',
        'updated_at',
    ];
}
