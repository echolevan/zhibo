<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $timestamps = false;
    protected $fillable = ['streams_name', 'relay_room_id', 'lecturer_id','status','room_name','desc','notice','thumb','number','barrage','speak','luck','created_time','is_vip','vip_pass', 'relay_amount'];
    public function lecturer()
    {
        return $this->belongsTo('App\Models\Lecturer');
    }

    public function relay(){
        return $this->belongsTo(Room::class, 'relay_room_id');
    }
}
