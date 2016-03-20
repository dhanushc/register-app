<?php
/**
 * Created by PhpStorm.
 * User: Lasith Niroshan
 * Date: 5/23/2015
 * Time: 1:50 PM
 */


class user{
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user = null) {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if(!$user){
            if(Session::exists($this->_sessionName)){
                $user = Session::get($this->_sessionName);
                if($this->find($user)){
                    $this->_isLoggedIn = true;
                } else {
                    //process logout
                }
            }
        } else {
            $this->find($user);
        }

    }

    public function update($fields = array(), $id=null){
        //for admin (can update any user details)
        if(!$id && $this->isLoggedIn()){
            $id = $this->data()->id;
        }

        if(!$this->_db->update('users', $id, $fields)) {
            throw new Exception('There was a problem updating..');
        }
    }

    public function create($fields = array()) {
        if(!$this->_db->insert('users', $fields)){
            throw new Exception('There was a problem creating an account.');
        }
    }

    public function find($user = null){
        if($user){
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));

            if($data->count()){
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

//    public function findAll($user = null){
//        if($user) {
//            $fields = (is_numeric($user)) ? 'id' : 'username';
//            $data =
//        }
//    }

    public function login($username=null, $password=null, $remember = false){
        if(!$username && !$password && $this->exists()) {
            //log user in
            Session::put($this->_sessionName, $this->data()->id);
        }else {
            $user = $this->find($username);
//            echo $username;
//            === is identical
            if ($user) {
                if ($this->data()->password === Hash::make($password)) {

                    Session::put($this->_sessionName, $this->data()->id);

//                    echo Hash::make($password);
                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

                        if (!$hashCheck->count()) {
                            $this->_db->insert('users_session', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }
                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }
                    return true;
                }
            }
        }
        return false;
    }


    public function hasPermission($key){
        $group = $this->_db->get('groups', array('id', '=', $this->data()->group));
//        print_r($group->first());


        if($group->count()){
            $permissions = json_decode($group->first()->permissions, true);
//            print_r($permission);


            if($permissions[$key] == true){
                return true;
            }
        }
        return false;

    }

    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }

    public function logout(){
        $this->_db->delete('users_session', array('user_id', '=', $this->data()->id));

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public  function data(){
        return $this->_data;
    }

    public function isLoggedIn(){
        return $this->_isLoggedIn;
    }

//    public function loadDropBoxData($table, $field){
//        $this->_db->loadDropBox($table, $field);
//    }
}

?>