<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forbid extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id','room_id','speak','ip'
    ];

}
