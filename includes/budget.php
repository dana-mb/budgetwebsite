<?php

    class Budget extends Db_object {

        protected static $table = "budgets";
        protected static $table_fields = array('category_name','user_id','amount','budget_start_date','budget_end_date');
        protected static $table_param_t = "siiss";
        public $category_name;
        public $user_id;
        public $amount;
        public $budget_start_date;
        public $budget_end_date;
        
        public static $sql_budgets = "CREATE TABLE IF NOT EXISTS `budgets` (
                                        `budget_id` int(11) NOT NULL AUTO_INCREMENT,
                                        `category_name` text NOT NULL,
                                        `user_id` int(11) NOT NULL,
                                        `amount` int(11) NOT NULL,
                                        `budget_start_date` date NOT NULL,
                                        `budget_end_date` date,
                                        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
                                        PRIMARY KEY (`budget_id`)
                                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

        
        function __construct($category_name=null, $amount=null, $budget_start_date=null, $budget_end_date=null) {
            if($category_name!=null OR $amount!=null OR $budget_start_date!=null) {    
                $this->category_name = $category_name;
                $this->user_id = $this->get_user_id();
                $this->amount = intval($amount);
                $this->budget_start_date = $budget_start_date;
                $this->budget_end_date = $budget_end_date;
            }
        }
        

        public static function create_table() {
            Db_object::create_table(self::$sql_budgets);
        }
        

        public function find_user_budgets() {

            $budget_array = self::find_by_query("SELECT * FROM ". self::$table ." WHERE `user_id` = ? ORDER BY `category_name`, `budget_start_date`", "i", [$this->get_user_id()]);
                
            return $budget_array;

        }


        public function find_user_budgets_from_x_category_and_date($categoryName, $budgetStartingDate) {

            $budget_array = self::find_by_query("SELECT * FROM ". self::$table ." WHERE `user_id` = ? AND `category_name` = ? AND `budget_start_date` = ?", "iss", [$this->get_user_id(), $categoryName, $budgetStartingDate]);
                
            return $budget_array;

        }

        
        public function find_budgets_start_date_from_x_category_order_by_date($categoryName) {

            $budget_array = self::find_by_query("SELECT `budget_start_date` FROM ". self::$table ." WHERE `user_id` = ? AND `category_name` = ? ORDER BY `budget_start_date`", "is", [$this->get_user_id(), $categoryName]);
                
            return $budget_array;

        }

        

    }


?>