<?php
/**
 * Created by PhpStorm.
 * User: Lasith Niroshan
 * Date: 5/23/2015
 * Time: 1:46 PM
 */

class DB{
    private static $_instance = null;
    private $_pdo_easypay,
//        $_pdo_academic,
        $_query,
        $_error = false,
        $_results,
        $_count = 0;

    private function __construct() {
        try {
            $this->_pdo_easypay = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
//            $this->_pdo_academic = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db2'), Config::get('mysql/username'), Config::get('mysql/password'));
//            echo "connected";
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function query($sql, $parms = array()){
        $this->_error = false;
        if ($this->_query = $this->_pdo_easypay->prepare($sql)) {
            $x = 1;
            if (count($parms)) {
                foreach ($parms as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }
    //$_pdo_academic
//    public function query2($sql, $parms = array()){
//        $this->_error = false;
//        if ($this->_query = $this->_pdo_academic->prepare($sql)) {
//            $x = 1;
//            if (count($parms)) {
//                foreach ($parms as $param) {
//                    $this->_query->bindValue($x, $param);
//                    $x++;
//                }
//            }
//            if ($this->_query->execute()) {
//                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
//                $this->_count = $this->_query->rowCount();
//            } else {
//                $this->_error = true;
//            }
//        }
//        return $this;
//    }
    /* try to new
    public function findLast($action, $table, $field1, $field2,$value) {
        $sql = "{$action} {$field1} FROM {$table} ORDER BY {$table}.{$field2} DESC";

        if(!$this->query($sql, array($value))->error()){
            return $this->first();
        }
        return false;
    }

    public function returnLast($table, $field1, $field2, $where){
        $finals = $this->findLast('SELECT', $table, $field1, $field2, $where);
        return $finals;
    }
    */

    public function getLast($table, $where) {
        return $this->getAll('SELECT *', $table, $where);
    }

    public function getAll($action, $table, $value){
        $sql = "{$action} FROM {$table} ";

        if(!$this->query($sql, array($value))->error()){
            return $this;
        }
        return false;
    }

//    public function getAll2($action, $table, $value){
//        $sql = "{$action} FROM {$table} ";
//
//        if(!$this->query2($sql, array($value))->error()){
//            return $this;
//        }
//        return false;
//    }

//    public function getField($action, $field, $table){
//        $sql = "{$action} {$field} FROM {$table}";
//
//        if(!$this->query($sql)){
//            return $this;
//        }
//        return false;
//    }
//
//    public function loadDropBox($field, $table){
//        $result = $this->getField('SELECT ',$field, $table);
//
//        echo "<select name='username'>";
//        while ($row = mysql_fetch_array($result)) {
//            echo "<option value='" . $row['username'] ."'>" . $row['username'] ."</option>";
//        }
//        echo "</select>";
//    }

    public function action($action, $table, $where = array()) {
        if (count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=', 'LIKE', 'NOT LIKE');

            $field      = $where[0];
            $operator   = $where[1];
            $value      = $where[2];

            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? ";

                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }

//    public function action2($action, $table, $where = array()) {
//        if (count($where) === 3) {
//            $operators = array('=', '>', '<', '>=', '<=', 'LIKE', 'NOT LIKE');
//
//            $field      = $where[0];
//            $operator   = $where[1];
//            $value      = $where[2];
//
//            if (in_array($operator, $operators)) {
//                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? ";
//
//                if (!$this->query2($sql, array($value))->error()) {
//                    return $this;
//                }
//            }
//        }
//        return false;
//    }

    public function getID( $table, $where)
    {
        return $this->action('SELECT id', $table, $where);
    }

    public function get($table, $where)
    {
        return $this->action('SELECT * ', $table, $where);
    }

    public function  delete($table, $where)
    {
        return $this->action('DELETE ', $table, $where);
    }

    public function insert($table, $fields = array()) {
        $keys = array_keys($fields);
        $values = '';
        $x = 1;

        foreach ($fields as $field) {
            $values .= '?';
            if ($x < count($fields)) {
                $values .= ', ';
            }
            $x++;
        }
//        $sql1 = INSERT INTO `lr`.`users` (`id`, `username`, `password`, `salt`, `name`, `joined`, `group`) VALUES ('1', 'lasith', 'lasith123', 'salt', 'lasith niroshan', '2015-06-23 08:13:25', '1');
        $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";
        if (!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }


    public function update($table, $id,  $fields){
        $set = '';
        $x = 1;

        foreach($fields as $name => $value){
            $set .= "{$name} = ?";
            if($x < count($fields)){
                $set .= ', ';
            }
            $x++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }


//    public function getID2( $table, $where)
//    {
//        return $this->action2('SELECT index_no', $table, $where);
//    }

//    public function get2($table, $where)
//    {
//        return $this->action2('SELECT * ', $table, $where);
//    }

//    public function  delete2($table, $where)
//    {
//        return $this->action2('DELETE ', $table, $where);
//    }
//
//    public function insert2($table, $fields = array()) {
//        $keys = array_keys($fields);
//        $values = '';
//        $x = 1;
//
//        foreach ($fields as $field) {
//            $values .= '?';
//            if ($x < count($fields)) {
//                $values .= ', ';
//            }
//            $x++;
//        }
////        $sql1 = INSERT INTO `lr`.`users` (`id`, `username`, `password`, `salt`, `name`, `joined`, `group`) VALUES ('1', 'lasith', 'lasith123', 'salt', 'lasith niroshan', '2015-06-23 08:13:25', '1');
//        $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";
//        if (!$this->query2($sql, $fields)->error()) {
//            return true;
//        }
//        return false;
//    }


//    public function update2($table, $id,  $fields){
//        $set = '';
//        $x = 1;
//
//        foreach($fields as $name => $value){
//            $set .= "{$name} = ?";
//            if($x < count($fields)){
//                $set .= ', ';
//            }
//            $x++;
//        }
//        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
//
//        if(!$this->query2($sql, $fields)->error()) {
//            return true;
//        }
//        return false;
//    }

    public function results(){
        return $this->_results;
    }

    public function first(){
        return $this->results()[0];
    }

    public function error(){
        return $this->_error;
    }

    public  function count(){
        return $this->_count;
    }


}

?>