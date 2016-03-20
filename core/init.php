<?php
/**
 * Created by PhpStorm.
 * User: Lasith Niroshan
 * Date: 5/23/2015
 * Time: 1:52 PM
 */

session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db' => 'ifestDB'
//        'db2' => 'educationDept_db'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800 //week in second
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);
//standard php library to autoload classes
spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});

require_once 'functions/sanitize.php';

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

    if($hashCheck->count()){
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}

?>