<?php

    class User extends Abstract_class {

        protected static $table = 'users';
        protected static $table_fields = array('email','unique_id','password','hashed_code','verified_status','token');
        protected static $table_param_t = "ssssss";
        protected $user_db_token;
        protected $user_computer_unique_id;
        protected $user_computer_token;
        public $user_id;
        public $email;
        public $unique_id;
        public $password;
        public $hashed_code;
        public $verified_status;
        public $token;
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


        function __construct($email=null, $unique_id=null, $password=null, $hashed_code=null, $verified_status=null, $token=null) {
            if($email!=null) {
                $this->email = $email;
                $this->unique_id = $unique_id;
                $this->password = $password;
                $this->hashed_code = $hashed_code;
                $this->verified_status = $verified_status;
            }
        }


        public static function create_table() {
            Abstract_class::create_table(self::$sql_users);
        }


        public function find_computer_unique_id_and_token() {

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

            $this->user_computer_unique_id = $user_computer_unique_id;
            $this->user_computer_token = $user_computer_token; 

        }
        

        public function find_user_info() {

            global $database;

            $this->find_computer_unique_id_and_token();

            $user_array = self::find_by_query("SELECT * FROM ". self::$table ." WHERE unique_id = ?", "s", [$this->user_computer_unique_id]);

            $this->userid = $user_array[0]->user_id;

            $this->user_db_token = $user_array[0]->token;

            // return $user_array;

        }
        
        // public function find_user_id() {

        //     $user_array = self::find_user_info();
            
        //     $this->$user_id = $user_array[0]->user_id;
            
        //     // return $user_id;

        // }

        // protected static function find_user_token() {

        //     $user_array = self::find_user_info();
            
        //     $user_token = $user_array[0]->token;
            
        //     self::$user_db_token = $user_token;

        // }


        public function find_user_by_email($email) {

            $user_results = self::find_by_query("SELECT * FROM ".self::$table." WHERE email = ?","s",[$email]);

            return $user_results;

        }



    }
    
    

?>