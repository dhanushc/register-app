<?php
/**
 * Created by PhpStorm.
 * User: Lasith Niroshan
 * Date: 5/23/2015
 * Time: 1:46 PM
 */
class Hash{
    public static function make($string, $salt = ''){
        return hash('sha256', $string . $salt );
    }
    /*
    public static function  salt($length){
        return mcrypt_create_iv($length);
    }
    */
    public static function unique(){
        return self::make(uniqid());
    }
}