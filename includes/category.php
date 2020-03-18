<?php

    class Category extends Abstract_class {

        protected static $table = "categories";
        protected static $table_fields = array('user_id','category_name');
        public $user_id;
        public $category_name;
        public static $sql_categories = "CREATE TABLE IF NOT EXISTS `categories` (
                                            `category_id` int(11) NOT NULL AUTO_INCREMENT,
                                            `user_id` int(11) NOT NULL,
                                            `category_name` text NOT NULL,
                                            FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
                                            PRIMARY KEY (`category_id`)
                                        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

        
        public static function create_table() {
            Abstract_class::create_table(self::$sql_categories);
        }


        public static function find_user_categories() {

            $category_array = self::find_by_query("SELECT * FROM ". self::$table ." WHERE user_id = ?", "i", Abstract_class::get_user_id());
                
            return $category_array;

            
        }
        
        public static function add_new_category($category_name) {

            $category = new Category();
                                
            // assigned static strings for the object:
            $category->user_id = self::get_user_id();
            $category->category_name = $category_name;
            
            // use the method:
            if($category->create()) {
                return "true";
            };

        }

    }


?>