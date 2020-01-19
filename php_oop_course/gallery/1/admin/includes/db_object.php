<?php

    class Db_object {

        public $errors = array();
        public $upload_errors_array = array(
            UPLOAD_ERR_OK         => "There is no error",
            UPLOAD_ERR_INI_SIZE   => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
            UPLOAD_ERR_FORM_SIZE  => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specific in the HTML",
            UPLOAD_ERR_PARTIAL    => "The uploaded file was only partially uploaded.",
            UPLOAD_ERR_NO_FILE    => "No file was uploaded.",
            UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
            UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
            UPLOAD_ERR_EXTENSION  => "A PHP extension stopped the file upload."
    
        );
        

        public function set_file($file) {

            if( empty($file) || !$file || !is_array($file) ) { //if there is no file
                $this->errors[] = "there was no file uploaded here"; //save the error in error array so we can display it later
                return false;

            }elseif ($file['error'] != 0) { //if there is a file but there is an error

                $this->errors[] = $this->upload_errors_array[ $file['error'] ]; //save the error in error array so we can display it later
                return false;

            } else {

                $this->user_image = basename($file['name']); // $file=$_FILES, basename- it gives only the user_image & escape
                                                        // the original name of the file which you have uploaded from the user computer
                $this->tmp_path = $file['tmp_name']; // the name of your file content- on the website server. the default naming done by PHP.
                $this->type     = $file['type'];
                $this->size     = $file['size'];

            }
            
        }

        
        public static function find_all() {
            return static::find_by_query("SELECT * FROM ". static::$db_table . " ");
            
            // lesson 48 - in the end he explains everything
            /*global $database;
            $result_set = $database->query("SELECT * FROM users");
            return $result_set;*/
        }


        public static function find_by_id($id) {
            global $database;
            $the_result_array = static::find_by_query("SELECT * FROM ". static::$db_table . " WHERE id= $id LIMIT 1");
            //$database->query("SELECT * FROM users WHERE id= $id LIMIT 1");
            
            return !empty($the_result_array) ? array_shift($the_result_array) : false;
            
        }


        public static function find_by_query($sql) {
            global $database;
            $result_set = $database->query($sql);
            //create an empty array to put our objects in there
            $the_object_array = array(); 
            
            // create a loop that fetches out table from the db and
            // bring back the result
            
            while($row = mysqli_fetch_array($result_set)) { 
                
                // we use the instantation method that loops through the 
                // columns & records and assign those to our objects' 
                // properties. we are replacing from our while loop
                // in admin content "$row['username']": 
                // $row to object and ['username'] to properties
                // and now we only bring them to the object array
                $the_object_array[] = static::instantation($row); 

            }

            return $the_object_array; 
        }


        public static function instantation($the_record) {
            
            //instead off new static like in the users class we estantiate the class 
            // from outside. we are doing late static binding - use the 
            // function get_called_class() instead of static
            $calling_class = get_called_class();
            $the_object = new $calling_class;
                            
            // $the_object->id         = $found_user['id'];
            // $the_object->username   = $found_user['username'];
            // $the_object->password   = $found_user['password'];
            // $the_object->first_name = $found_user['first_name'];
            // $the_object->last_name  = $found_user['last_name'];

            foreach ($the_record as $the_attribute => $value) {

                if($the_object->has_the_attribute($the_attribute)) {

                    $the_object->$the_attribute = $value;

                }

            }

            return $the_object;
            
        }


        private function has_the_attribute($the_attribute) {

            $object_properties = get_object_vars($this);

            return array_key_exists($the_attribute, $object_properties);

        }


        protected function properties() {

            $properties = array();
            foreach (static::$db_table_fields as $db_field) { 
                // check if the property (value- $db_field) from the 
                // array exist in $this- the class. if it does exist it 
                // will be assign to $property array
                if(property_exists($this, $db_field)) { 
                    // because db_field is not a property (it's just a name we gave) it gets $.
                    $properties [$db_field] = $this->$db_field; 
                }
            }

            return $properties;

        }


        protected function clean_properties() {
            global $database;

            $clean_properties= array();
            // take the keys&values from properties() array. 
            // clean the values and assign them again tp the keys and the new array
            foreach ($this->properties() as $key => $value) { 
                $clean_properties[$key] = $database->escape_string($value);
            }

            return $clean_properties;
        }


        public function save() {

            // check to see if the id is in our database. 
            // if it is - it will only update it, if it's not - it will create it
            return isset($this->id) ? $this->update() : $this->create();

        }


        public function create() {

            global $database;

            $properties = $this->clean_properties();

            $sql = "INSERT INTO " .static::$db_table. "(" . implode( ",", array_keys($properties) ) . ")";
            
            //apply all the values to our object: except the auto incremented id:
            
            $sql .= " VALUES ('". implode( "','", array_values($properties) ) ."')";
            
            // $sql .= $database->escape_string($this->username)   . "', '";
            // $sql .= $database->escape_string($this->password)   . "', '";
            // $sql .= $database->escape_string($this->first_name) . "', '";
            // $sql .= $database->escape_string($this->last_name)  . "')";

            if($database->query($sql)) {
                // pull the id and also assign it to our object by a method 
                // from database class even though we can do it here 
                // (mysqli_insert_id which returns the id from the last query):
                $this->id = $database->the_insert_id();
                
                return true;

                //estantiate the user class, assigned static strings for the object(username..)
            } else {
                return false;
            }
            
        }


        public function update() {

            global $database;
            $properties = $this->clean_properties();

            $properties_pairs = array();

            foreach ($properties as $key => $value) {
                // make the $key => $value look like (apply all the values to our object):
                // "username= '" . $database->escape_string($this->username) . "', ";
                // and assign is to properties_pairs
                $properties_pairs[] = " {$key} = '{$value}' "; // single quotes for the strings
                
            }

            $sql = "UPDATE " .static::$db_table. " SET ";
            $sql .= implode( ",", $properties_pairs );
            $sql .= " WHERE id= " . $database->escape_string($this->id); // make sure to have a space before the where, 
                                                                        // without a single quote- not a string, an integer

            $database->query($sql);
                
            return (mysqli_affected_rows($database->connection) == 1) ? true : false;

        }


        // public function delete() {

        //     global $database;

        //     $sql = "DELETE FROM " .static::$db_table. " WHERE ";
        //     //apply all the values to our object:
        //     // $sql .= "id= " . $database->escape_string($this->id)                  . "AND "; // without a single quote- not a string, an integer
        //     $sql .= "username= '" . $database->escape_string($this->username)     . "' AND "; // with a single quote- a string
        //     $sql .= "password= '" . $database->escape_string($this->password)     . "' AND ";
        //     $sql .= "first_name= '" . $database->escape_string($this->first_name) . "' AND ";
        //     $sql .= "last_name= '" . $database->escape_string($this->last_name)   . "'     ";
            
            
        //     $database->query($sql);

        //     return (mysqli_affected_rows($database->connection) == 1) ? true : false;

        // }


        public function delete() {

            global $database;

            $sql = "DELETE FROM " .static::$db_table. " WHERE ";
            //apply all the values to our object:
            $sql .= "id= " . $database->escape_string($this->id); // without a single quote- not a string, an integer
            $sql .= " LIMIT 1";
            
            $database->query($sql);

            return (mysqli_affected_rows($database->connection) == 1) ? true : false;

        }



    }


?>