<?php

    class Expense extends Abstract_class {

        protected static $table = "expenses";
        protected static $table_fields = array('user_id','amount','category_name','date','details');
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