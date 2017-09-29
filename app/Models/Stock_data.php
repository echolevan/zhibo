<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock_data extends Model
{
    protected $table = 'stock_data';
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'operate','code','name','number','t_price','h_price','price','market','account','time','created_time'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
