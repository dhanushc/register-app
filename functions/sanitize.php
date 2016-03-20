<?php
/**
 * Created by PhpStorm.
 * User: Lasith Niroshan
 * Date: 5/23/2015
 * Time: 1:53 PM
 */

function escape($string){
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

?>