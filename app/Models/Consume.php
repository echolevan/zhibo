<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consume extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'type', 'user_id', 'created_time','price','to_user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function toUser()
    {
        return $this->belongsTo('App\User','to_user_id');
    }
}
