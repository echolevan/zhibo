<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//直播历史
class Live_history extends Model
{
    protected $table = 'live_history';
    public $timestamps = false;
    protected $fillable = [
        'title', 'user_id','thumb','url','created_time','count','status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
