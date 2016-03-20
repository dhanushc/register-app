<?php
/**
 * Created by PhpStorm.
 * User: anjana
 * Date: 1/3/16
 * Time: 6:18 PM
 */

class Mail{

    private $_headers="From: easypayucsc2@gmail.com";

    public function sendMail($to,$subject,$message){
        mail($to,$subject,$message,$this->_headers);
    }
}