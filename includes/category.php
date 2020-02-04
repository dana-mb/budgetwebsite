<?php

    class Category extends Abstract_class {

        protected static $table;
        protected static $table_fields = array('user_id','category_name');
        public $user_id;
        public $category_name;
        

        

    }


?>