<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id','to_user_id','title','reply','status','type','is_read','created_time','end_time','reply_price'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tuUser()
    {
        return $this->belongsTo('App\User','to_user_id');
    }
}
