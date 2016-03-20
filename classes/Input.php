<?php
/**
 * Created by PhpStorm.
 * User: Lasith Niroshan
 * Date: 5/23/2015
 * Time: 1:47 PM
 */
class Input
{
    public static function exists($type = 'post')
    {
        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;
            case 'get':
                return (!empty($_GET)) ? true : false;
                break;
            default:
                return false;
                break;
        }
    }

    public static function  get($item){
        if(isset($_POST[$item])){
            return $_POST[$item];
        } else if (isset($_GET[$item])){
            return $_GET[$item];
        }
        return '';
    }
}

?>