<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawals extends Model
{
    protected $table = 'withdrawals';
    public $timestamps = false;
    protected $fillable = [
        'user_name',
        'user_type',
        'user_id',
        'account_type',
        'account',
        'amount',
        'status',
        'examine_status',
        'create_time',
        'examine_time',
        'pay_time',
    ];
}








