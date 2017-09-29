<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveMessage extends Model
{
    protected $table = 'livemessages';
    public $timestamps = false;
    protected $fillable = [
        'title', 'user_id','thumb', 'start_time','end_time','created_time',
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
