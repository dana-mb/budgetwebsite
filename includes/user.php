<?php

    class User extends Abstract_class {

        protected static $table = 'users';
        protected static $table_fields = array('email','unique_id','password','hashed_code','verified_status','token');
        protected static $user_array;
        protected static $user_computer_unique_id;
        protected static $user_computer_token;
        protected static $user_db_token;
        public $user_id;
        public $email;
        public $unique_id;
        public $password;
        public $hashed_code;
        public $verified_status;
        public $token;
        public static $name;
        public static $sql_users = "CREATE TABLE IF NOT EXISTS `users` (
                                        `user_id` int(11) NOT NULL AUTO_INCREMENT,
                                        `email` text NOT NULL,
                                        `unique_id` text NOT NULL,
                                        `password` text NOT NULL,
                                        `hashed_code` text NOT NULL,
                                        `verified_status` text NOT NULL,
                                        `token` text,
                                        PRIMARY KEY (`user_id`)
                                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";


        public static function create_table() {
            Abstract_class::create_table(self::$sql_users);
        }


        protected static function find_computer_unique_id_and_token() {

            if ( NULL !== $_SESSION['budget_website_session'] ) 
            {
                list($user_computer_unique_id,$user_computer_token)=explode("-", $_SESSION['budget_website_session']);
            }

            else if ( NULL !== $_COOKIE['budget_website_cookie'] ) 
            {
                list($user_computer_unique_id,$user_computer_token)=explode("-", $_COOKIE['budget_website_cookie']);
            }
            else {
                echo "could'nt find user";
            }

            self::$user_computer_unique_id = $user_computer_unique_id;
            self::$user_computer_token = $user_computer_token; 

        }

        protected static function find_user_info() {
            
            Session::start();

            global $database;

            self::find_computer_unique_id_and_token();

            $user_array = self::find_by_query("SELECT * FROM ". self::$table ." WHERE unique_id = ?", "s", self::$user_computer_unique_id);
                
            return $user_array;
            

        }
        
        public static function find_user_id() {

            $user_array = self::find_user_info();
            
            $user_id = $user_array[0]->user_id;
            
            return $user_id;

        }

        protected static function find_user_token() {

            $user_array = self::find_user_info();
            
            $user_token = $user_array[0]->token;
            
            self::$user_db_token = $user_token;

        }
        


    }
    
    

?>