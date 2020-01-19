<?php

    class Category extends Abstract_class {

        protected static $abstract_table;
        protected static $abstract_table_fields = array('user_id','category_name');
        public $user_id;
        public $category_name;
        

        

    }


?>