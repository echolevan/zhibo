<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    //
    protected $table = 'word';
    public $timestamps = false;
    protected $fillable = [
        'word', 'ctime','etime'
    ];
}









