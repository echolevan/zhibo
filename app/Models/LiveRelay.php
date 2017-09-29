<?php
/**
 * @author: hemengze@cmstop.com
 * Date: 2017/9/19 21:23
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveRelay extends Model{

    protected $table = 'live_relay';
    protected $fillable = [
        'from_room', 'to_room', 'expire_at', 'amount'
    ];

    public function fromRoom(){
        return $this->belongsTo(Room::class, 'from_room');
    }

    public function toRoom(){
        return $this->belongsTo(Room::class, 'to_room');
    }
}