<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Focus extends Model
{
    protected $table = 'focus';
    protected $fillable = [
        'thumb', 'small', 'desc','sort','lecturer_id'
    ];

    public function lecturer()
    {
        return $this->hasOne('App\Models\Lecturer','id','lecturer_id');
    }
}
