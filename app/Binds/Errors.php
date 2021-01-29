<?php namespace App\Binds;

class Errors{
    public static $data = [];
    public static function get(){
        return self::$data;
    }
    public static function set($errors = []){
        self::$data = array_merge(self::$data,$errors);
    }
}
