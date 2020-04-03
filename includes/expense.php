<?php

    class Expense extends Abstract_class {

        protected static $table = "expenses";
        protected static $table_fields = array('user_id','amount','category_name','date','details');
        public $user_id;
        public $amount;
        public $category_name;
        public $date;
        public $details;
        public static $sql_expenses = "CREATE TABLE IF NOT EXISTS `expenses` (
                            `expense_id` int(11) NOT NULL AUTO_INCREMENT,
                            `user_id` int(11) NOT NULL,
                            `amount` DECIMAL (8, 2) NOT NULL,
                            `category_name` text NOT NULL,
                            `date` date NOT NULL,
                            `details` text,
                            FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
                            PRIMARY KEY (`expense_id`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

        public static function create_table() {
            Abstract_class::create_table(self::$sql_expenses);
        }
        
        
        public static function find_user_expenses() {

            $expense_array = self::find_by_query("SELECT * FROM ". self::$table ." WHERE user_id = ?", "i", [Abstract_class::get_user_id()]);
                
            return $expense_array;

            
        }




    }


?>