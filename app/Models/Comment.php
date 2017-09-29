<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;
    protected $fillable = ['article_id','back_live_id','user_id','parent_id','contents','status','created_time'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Comment','parent_id','id');
    }
}
