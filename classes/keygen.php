<?php
/**
 * Created by PhpStorm.
 * User: lasith-niro
 * Date: 12/08/15
 * Time: 08:45
 */

class keygen {
    public function __construct($string, $number){
        $str=$string . $number;
        return $str;
    }
} 