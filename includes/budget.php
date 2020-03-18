<?php

    class Budget extends Abstract_class {

        protected static $table = "budgets";
        protected static $table_fields = array('category_name','user_id','amount','budget_start_date','budget_end_date');
        public $category_name;
        public $user_id;
        public $amount;
        public $budget_start_date;
        public $budget_end_date;
        
        public static $sql_budgets = "CREATE TABLE IF NOT EXISTS `budgets` (
                                        `category_name` text NOT NULL,
                                        `budget_id` int(11) NOT NULL AUTO_INCREMENT,
                                        `user_id` int(11) NOT NULL,
                                        `amount` int(11) NOT NULL,
                                        `budget_start_date` date NOT NULL,
                                        `budget_end_date` date,
                                        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
                                        PRIMARY KEY (`budget_id`)
                                        
                                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

        
        public static function create_table() {
            Abstract_class::create_table(self::$sql_users);
        }
        

        public static function find_user_budgets() {

            $budget_array = self::find_by_query("SELECT * FROM ". self::$table ." WHERE user_id = ? ORDER BY `category_name`, `budget_start_date`", "i", Abstract_class::get_user_id());
                
            return $budget_array;

        }


        public static function add_new_budget($amount, $category_name, $date, $details) {

            $budget = new Budget();
                                
            // assigned static strings for the object:
            $budget->category_name = $category_name;
            $budget->user_id = self::get_user_id();
            $budget->amount = $amount;
            $budget->budget_start_date = $budget_start_date;
            $budget->budget_end_date = $budget_end_date;

            // use the method:
            if($budget->create()) {
                return "true";
            };

        }


    }


?>