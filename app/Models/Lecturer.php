<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'user_id','username','status', 'grade','income','type','reply_price','auth_id_number','created_time','open_time','desc',
        'front_picture','back_picture','hand_picture','admin_id','sort','lecturer_type'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function room()
    {
        return $this->hasOne('App\Models\Room');
    }

}
