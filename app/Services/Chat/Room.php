<?php
/**
 * @author: hemengze@cmstop.com
 * Date: 2017/9/21 23:04
 */

namespace App\Services\Chat;


class Room{

    const ROOM_KEY = 'chat:room:%s';

    const ROOM_HISTORY_KEY = 'chat:room:%s:history';

    static function getRoom($roomId){
        $key = self::getRoomKey($roomId);
        return \Redis::connection('chat')->sMembers($key);
    }

    static function joinRoom($roomId, $fd){
        $key = self::getRoomKey($roomId);
        return \Redis::connection('chat')->sAdd($key, $fd);
    }

    static function quitRoom($roomId, $fd){
        $key = self::getRoomKey($roomId);
        return \Redis::connection('chat')->sRem($key, $fd);
    }

    static function clear(){
        \Redis::connection('chat')->flushdb();
    }

    protected static function getRoomKey($roomId){
        return sprintf(self::ROOM_KEY, $roomId);
    }

    protected static function getHistoryKey($roomId){
        return sprintf(self::ROOM_HISTORY_KEY, $roomId);
    }

}