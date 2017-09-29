<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'stock_data_id','gain','earnings','created_time','time'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Delivery_comment','delivery_id')->where('parent_id','=','0');
    }

}
