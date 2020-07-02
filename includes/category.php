<?php

class Category extends Db_object
{

    protected static $table = "categories";
    protected static $table_fields = array('user_id', 'category_name');
    protected static $table_param_t = "is";
    public $user_id;
    public $category_name;
    public static $sql_categories = "CREATE TABLE IF NOT EXISTS `categories` (
                                            `category_id` int(11) NOT NULL AUTO_INCREMENT,
                                            `user_id` int(11) NOT NULL,
                                            `category_name` text NOT NULL,
                                            FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
                                            PRIMARY KEY (`category_id`)
                                        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";


    public function __construct($user_id = null, $category_name = null)
    {
        if($category_name != null) {
            ($user_id == null)? $this->user_id = $this->get_user_id() : $this->user_id = $user_id;
            $this->category_name = $category_name;
        }
    }


    public static function create_table()
    {
        Db_object::create_table(self::$sql_categories);
    }

    public function find_user_categories()
    {
        $category_array = self::find_by_query("SELECT * FROM " . self::$table . " WHERE user_id = ?", "i", [$this->get_user_id()] );

        return $category_array;
    }

    public function find_last_inserted_category()
    {
        $category_array = self::find_by_query("SELECT `category_name` FROM " . self::$table . " WHERE `category_id`= (SELECT MAX(`category_id`) FROM ". self::$table ." WHERE user_id = ?)", "i", [$this->get_user_id()] );

        return $category_array;
    }
}
