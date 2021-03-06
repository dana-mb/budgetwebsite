<?php

require_once("config.php");


class Database {
    
    public $connection;

    function __construct() {
        $this->connection();
    }

    public function connection() {
        $this->connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

        if($this->connection->connect_errno) {
            die("Database connection failed badly" . $this->connection->connect_error);
        }

    }


    public function query($sql, $param_k, $param) {
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param($param_k, ...$param); //$param_k: kind of variables(i-integer, d-decimal, s-string), $param: the variables themselves.
        //if the ... way is not compatible for most users than use:
            // $bind_names[] = $param_k;
            // for ($i=0; $i<count($param);$i++) {
            //   $bind_name = 'bind' . $i;
            //   $$bind_name = $param[$i];
            //   $bind_names[] = &$$bind_name;
            // }
            // $return = call_user_func_array(array($stmt,'bind_param'),$bind_names);

        if ($stmt->execute() AND !preg_match('/(SELECT)/', $sql)) { //if its select query it's suppose to return only results, if its something else it's soppose to check if the query has been executed
            return true;
        };
        $result = $stmt->get_result();
        $stmt->close();
        if ($result) {
            return $result;
        };
        
    }   

    public static function create_table($sql) {
        $db = new self();
        $db->connection->query($sql);
    }
    

}

$database = new Database();
