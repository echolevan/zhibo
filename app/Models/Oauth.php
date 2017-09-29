<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oauth extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'idstr',
        'nickname',
        'avatar_url',
        'email',
        'type',
        'created_time'
    ];

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
