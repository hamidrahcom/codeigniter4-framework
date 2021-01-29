<?php namespace App\Binds;

class User{
    public static $online = null;
    public static $token_key = 'token';
    public static function get(){
        return self::$online;
    }
    public static function set($user){
        self::$online = $user;
    }
}
