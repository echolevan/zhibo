<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id','from_id','price','created_time','type'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','from_id');
    }
}
