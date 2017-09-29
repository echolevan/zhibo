<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gifts extends Model
{
    //
    protected $table = 'gift';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
        'price',
        'tyep',
        'is_delete',
        'promotion_begin_time',
        'promotion_end_time',
        'promotion_price',
        'img',
        'gif',
        'create_time'
    ];
}









