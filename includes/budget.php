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

        
        function __construct($category_name=null, $amount=null, $budget_start_date=null, $budget_end_date=null) {
            if($category_name!=null && $amount!=null && $budget_start_date!=null) {    
                $this->category_name = $category_name;
                $this->user_id = $this->get_user_id();
                $this->amount = $amount;
                $this->budget_start_date = $budget_start_date;
                ($budget_end_date)? $this->budget_end_date=$budget_end_date: null;
            }
        }
        

        public static function create_table() {
            Abstract_class::create_table(self::$sql_users);
        }
        

        public function find_user_budgets($userid = null) {

            $budget_array = self::find_by_query("SELECT * FROM ". self::$table ." WHERE user_id = ? ORDER BY `category_name`, `budget_start_date`", "i", [($userid == null)? $this->get_user_id():$userid]);
                
            return $budget_array;

        }


        public function find_user_budgets_from_x_category_and_date($categoryName, $budgetStartingDate, $userid = null) {

            $budget_array = self::find_by_query("SELECT * FROM ". self::$table ." WHERE user_id = ? AND `category_name` = ? AND `budget_start_date` = ?", "iss", [($userid == null)? $this->get_user_id():$userid, $categoryName, $budgetStartingDate]);
                
            return $budget_array;

        }

        
        public function find_budgets_start_date_from_x_category_order_by_date($categoryName, $userid = null) {

            $budget_array = self::find_by_query("SELECT `budget_start_date` FROM ". self::$table ." WHERE user_id = ? AND `category_name` = ? ORDER BY `budget_start_date`", "is", [($userid == null)? $this->get_user_id():$userid, $categoryName]);
                
            return $budget_array;

        }


    }


?>