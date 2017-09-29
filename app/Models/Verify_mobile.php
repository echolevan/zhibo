<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verify_mobile extends Model
{
    protected $table = 'mobile_code';
    public $timestamps = false;
    protected $fillable = [
        'phone', 'verification_code','number','post_time','status',
    ];
}
