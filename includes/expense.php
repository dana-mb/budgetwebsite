<?php

    class Expense extends Abstract_class {

        protected static $abstract_table = "expenses";
        protected static $abstract_table_fields = array('user_id','amount','category_name','date','details');
        public $user_id;
        public $amount;
        public $category_name;
        public $date;
        public $details;


        // public static function add_an_expense() {

        //     create

        // }
        
        
        



    }


?>