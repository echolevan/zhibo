<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift_history extends Model
{
    //
    protected $table = 'gift_history';
    public $timestamps = false;
    protected $fillable = [
        'gift_id',
        'gift_name',
        'gift_price',
        'send_name',
        'send_id',
        'num',
        'all_price',
        'receiver_name',
        'receiver_id',
        'create_time',
    ];
    public function gift()
    {
        return $this->hasOne('App\Models\Gifts','id','gift_id');
    }
}









