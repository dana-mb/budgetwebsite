<?php

    class User extends Abstract_class {

        protected static $abstract_table;
        protected static $abstract_table_fields = array('email','unique_id','password','hashed_code','verified_status','token');
        public $email;
        public $unique_id;
        public $password;
        public $hashed_code;
        public $verified_status;
        public $token;

        
        public function __construct() {

            session_start();

            if ( NULL !== $_SESSION['budget_website_session']) 
            {
                list($unique_id,$token)=explode("-", $_SESSION['budget_website_session']);
                
                $stmt = $link->prepare("SELECT * FROM users WHERE unique_id = ?");
                $stmt->bind_param("s", $unique_id);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
                $user_id = $user['user_id'];
            }

            else if ( NULL !== $_COOKIE['budget_website_cookie']) 
            {
                list($unique_id,$token)=explode("-", $_COOKIE['budget_website_cookie']);
                
                $stmt = $link->prepare("SELECT * FROM users WHERE unique_id = ?");
                $stmt->bind_param("s", $unique_id);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
                $user_id = $user['user_id'];
            }    
            else {
                echo "could'nt find user_id";
            }

        }

        


    }


?>