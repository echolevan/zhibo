<?php
/**
 * @author: hemengze@cmstop.com
 * Date: 2017/9/21 23:06
 */

namespace App\Services\Chat;

class User{

    const USER_KEY = 'chat:user:%d';


    static function setUser($fd, $user){
        $key = self::getUserKey($fd);
        return \Redis::connection('chat')->hMset($key, $user);
    }

    static function getUser($fd){
        $key = self::getUserKey($fd);
        return \Redis::connection('chat')->hGetAll($key);
    }

    static function removeUser($fd){
        $key = self::getUserKey($fd);
        return \Redis::connection('chat')->del($key);
    }

    protected static function getUserKey($fd){
        return sprintf(self::USER_KEY, $fd);
    }
}