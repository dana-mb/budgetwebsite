<?php

    class Budget extends Abstract_class {

        protected static $table;
        protected static $table_fields = array('category_name','user_id','amount','budget_start_date','budget_end_date');
        public $category_name;
        public $user_id;
        public $amount;
        public $budget_start_date;
        public $budget_end_date;
        

        

    }


?>