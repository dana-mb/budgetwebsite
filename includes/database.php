<?php

require_once("config.php");


class Database {
    
    public $connection;

    function __construct() {
        $this->connection();
    }

    public function connection() {
        //old way: $this->connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $this->connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

        if($this->connection->connect_errno) {
            die("Database connection failed badly" . $this->connection->connect_error);
        }

    }

    // $stmt = $link->prepare("SELECT * FROM users WHERE unique_id = ?");
    // $stmt->bind_param("s", $unique_id);
    // $stmt->execute();
    // $user = $stmt->get_result()->fetch_assoc();
    // $user_id = $user['user_id'];

/////////new
    public function query($sql, $param_k, $param) {
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param($param_k, $param); //$param_k: kind of variables(i-integer, d-decimal, s-string), $param: the variables themselves.
        if ($stmt->execute() AND !preg_match('/(SELECT)/', $sql)) { //if its select query it's suppose to return only results, if its something else it's soppose to check if the query has been executed
            return true;
        };
        $result = $stmt->get_result();
        // $this->confirm_query($result);
        $stmt->close();
        if ($result) {
            return $result;
        };
        
}

//     private function confirm_query($result) {
//         if(!$result) {
//             die("Query Failed" . $this->connection->error);
//         }
//     }

////////

////////old
    // public function query($sql) {
    //     $result = $this->connection->query($sql);
    //     // $this->confirm_query($result);
    //     return $result;
    // }

    // public function query($sql) {
    //     $result = $this->connection->query($sql);
    //     $this->confirm_query($result);
    //     return $result;
    // }

    // private function confirm_query($result) {
    //     if(!$result) {
    //         die("Query Failed" . $this->connection->error);
    //     }
    // }

    public function escape_string($string) {
        $escape_string = $this->connection->real_escape_string($string);
        return $escape_string;
    }

    public function the_insert_id() {
        
        return mysqli_insert_id($this->connection);
        // return $this->connection->insert_id;
    }

    public static function create_table($sql) {
        $db = new self();
        $db->connection->query($sql);
    }
    

}

$database = new Database();
