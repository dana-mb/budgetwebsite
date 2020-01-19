<?php

    class Comment extends Db_object { //it will inheret properties$methods from Db_object

        protected static $db_table = "comments"; //abstract attribute
        protected static $db_table_fields = array('photo_id', 'autor', 'body'); 
        public $id;
        public $photo_id;
        public $autor;
        public $body;
    

        public static function create_comment($photo_id, $autor="John", $body="") {

            if(!empty($photo_id) && !empty($autor) && !empty($body)) {

                $comment = new Comment();

                $comment->photo_id = (int)$photo_id; //makes sure that this is integer
                $comment->autor    = $autor;
                $comment->body     = $body;

                return $comment;

            } else {

                return false;
            
            }

        }


        // find the comments that are related to specific photo_id
        public static function find_the_comments($photo_id = 0) {

            global $database; //bring it here in order to use the escape string method

            $sql  = "SELECT * FROM " . self::$db_table;
            $sql .= " WHERE photo_id = " . $database->escape_string($photo_id);
            $sql .= " ORDER BY photo_id ASC";

            return self::find_by_query($sql);

        }



    }


?>