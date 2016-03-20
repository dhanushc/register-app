<?php
/**
 * Created by PhpStorm.
 * User: Lasith Niroshan
 * Date: 5/23/2015
 * Time: 1:45 PM
 */
class Config{
    public static function get($path = null){
        if($path){
            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach($path as $bit){
                 if(isset($config[$bit])){
                     $config = $config[$bit];
                 }
            }
//            print_r($path);
            return $config;
        }
        return false;
    }
}
?>