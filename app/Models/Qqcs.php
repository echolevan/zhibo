<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qqcs extends Model
{
    //
    protected $table = 'qqcs';
    public $timestamps = false;
    protected $fillable = [
        'name', 'qq','status','ctime','etime'
    ];
}









