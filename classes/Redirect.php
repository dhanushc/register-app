<?php
/**
 * Created by PhpStorm.
 * User: Lasith Niroshan
 * Date: 5/23/2015
 * Time: 1:48 PM
 */
class Redirect {

    public static function to($location  = null){
        if($location){
            if(is_numeric($location)){
                switch($location){
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        include 'include/errors/404.php';
                        exit();
                        break;
                    /*
                    case 502:

                    break;
                     */
                }
            }
            header('Location: ' . $location );
            exit();
        }
    }
}
?>
