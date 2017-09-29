<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery_comment extends Model
{
    protected $table = 'delivery_comment';
    public $timestamps = false;
    protected $fillable = [
        'user_id','delivery_user_id','delivery_id','parent_id','evaluate','contents','created_time'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Delivery_comment','parent_id','id');
    }

}
