<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public $timestamps = false;
    protected $fillable = ['my_id','user_id','created_time'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function fans()
    {
        return $this->belongsTo('App\User','my_id');
    }
}
