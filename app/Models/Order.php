<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'order_id', 'user_id', 'type','status','amount','created_time','updated_time','delete_time'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
