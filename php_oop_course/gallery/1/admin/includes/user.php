<?php

    class User extends Db_object { //it will inheret properties$methods from Db_object

        protected static $db_table = "users"; //abstract attribute
        protected static $db_table_fields = array('username', 'password', 'first_name','last_name', 'user_image'); 
        public $id;
        public $username;
        public $password;
        public $first_name;
        public $last_name;
        public $user_image;
        public $upload_directory = "images";
        public $image_placeholder = "http://placehold.it/400x400&text=image";


        


        public function image_path_and_placeholder() {
            return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory .DS. $this->user_image;
        }


        public static function verify_user($username, $password) {

            global $database;

            $username = $database->escape_string($username);
            $password = $database->escape_string($password);

            $sql = "SELECT * FROM ". self::$db_table . " WHERE ";
            $sql .= "username = '{$username}' ";
            $sql .= "AND password = '{$password}' ";
            $sql .= "LIMIT 1";

            $the_result_array = self::find_by_query($sql);
            
            return !empty($the_result_array) ? array_shift($the_result_array) : false; //tunary syntax, array_shift get the first row.
        }


        public function upload_photo() {

            if( !empty($this->errors) ) { // if there are errors return false
                return false;
            }

            if( empty($this->user_image) || empty($this->tmp_path) ) { // if the file/tmp_path is empty put the string in the errors array
                $this->errors[] = "the file was not available";
                return false;
            }

            // create our target path (permanent location) with our user_image (make sure this is writable)
            $target_path = SITE_ROOT .DS. 'admin' .DS. $this->upload_directory .DS. $this->user_image;

            if( file_exists($target_path) ) {

                $this->errors[] = "the file {$this->user_image} already exists";
                return false;

            }

            // move_uploaded_file(user_image, destination) valid upload file 
            // (meaning that it was uploaded via PHP's HTTP POST upload mechanism).
            if( move_uploaded_file($this->tmp_path, $target_path) ) {

                unset($this->tmp_path); // because we dont need it anymore
                return true;
            

            } else {

                $this->errors[] = "the file directory probably does not have permission";
                return false;

            }

        }




    }


?>