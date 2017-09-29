<?php
/**
 * @author: hemengze@cmstop.com
 * Date: 2017/9/25 21:14
 */

namespace App\Services\Relay;

class RelayCancel{

    protected static $cancel_key = 'relay:cancel:%d';


    public static function cancel($room_id){
        $key = sprintf(self::$cancel_key, $room_id);
        return \Redis::setEx($key, 3600, 1);
    }

    public static function cancelAble($room_id){
        $key = sprintf(self::$cancel_key, $room_id);
        return \Redis::exists($key);
    }

    public static function removeCancel($room_id){
        $key = sprintf(self::$cancel_key, $room_id);
        return \Redis::delete($key);
    }
}