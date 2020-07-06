<?php

    class Db_object extends Database {
        public $userid;
        
        public static function create_table($sql) {
            Database::create_table($sql);
        }


        public function get_user_id() {
                $user = new User();
                $user->find_user_info();
                return $user->userid;
            
        }

        public static function find_by_query($sql, $param_k, $param) {
            global $database;
            $result_set = $database->query($sql, $param_k, $param);
            //create an empty array to put our objects in there
            $the_object_array = array(); 
            
            // create a loop that fetches out table from the abstract and
            // bring back the result
            
            while($row = mysqli_fetch_array($result_set)) { 
                
                // I use the instantation method that loops through the 
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
            foreach (static::$table_fields as $table_field) { 
                // check if the property (value- $db_field) from the 
                // array exist in $this- the class. if it does exist it 
                // will be assign to $property array
                //  AND !empty($this->$table_field)
                if(property_exists($this, $table_field) AND !empty($this->$table_field)) { 
                    // because db_field is not a property (it's just a name we gave) it gets $.
                    $properties [$table_field] = $this->$table_field; 
                }
            }
            return $properties;
        }


        public function create() {
            global $database;

            $properties = $this->properties();

            $sql = "INSERT INTO " .static::$table. "(" . implode( ",", array_keys($properties) ) . ")";
            
            //apply all the values to our object: except the auto incremented id:
            
            $sql .= " VALUES (".implode( ",", array_fill(0, count($properties), '?') ).") ";
            
            $param = array_values($properties);

            $param_substr = static::$table_param_t;
            $param_substr_len = strlen($param_substr);
            $properties_count = sizeof($properties);
            
            // if the param kind is more than the number of properties than remove the last letters from parameter kind 
            $param_str = ($properties_count == $param_substr_len) ? $param_substr : substr($param_substr, 0, -($param_substr_len-$properties_count));

            if($database->query($sql, $param_str, $param) == true) {
                return ($database->connection->affected_rows == -1) ? true : false;

                //estantiate the user class, assigned static strings for the object(username..)
            } else {
                return false;
            }
        }


        public function update($tableField, $new_value, $param_kind) {

            global $database;
            $properties = $this->properties();
            $properties_pairs = array();

            foreach ($properties as $key => $value) {
                // make the $key => $value look like (apply all the values to our object):
                // "username= '" . $database->escape_string($this->username) . "', ";
                // and assign is to properties_pairs
                $properties_pairs[] = " `{$key}` = ? "; // single quotes for the strings
                
            }

            $sql = "UPDATE " .static::$table. " SET ";
            $sql .= " `{$tableField}` = ? ";
            $sql .= " WHERE ";                  // make sure to have a space before the where, 
            $sql .= implode( " AND ", $properties_pairs );

            $param = array_values($properties);
            array_unshift($param, $new_value);

            if($database->query($sql, $param_kind, $param) == true) {
                return ($database->connection->affected_rows == -1) ? true : false;
            } else {
                return false;
            }

        }


        public function delete() {

            global $database;
            $properties = $this->properties();

            $sql = "DELETE FROM " .static::$table. " WHERE ";
            $properties_pairs = array();

            foreach ($properties as $key => $value) {
                // make the $key => $value look like (apply all the values to our object):
                // "username= '" . $database->escape_string($this->username) . "', ";
                // and assign is to properties_pairs
                $properties_pairs[] = " `{$key}` = ? "; // single quotes for the strings
                
            }
            $sql .= implode( "AND", $properties_pairs );
            
            $param_substr = static::$table_param_t;
            $param_substr_len = strlen($param_substr);
            $properties_count = sizeof($properties);
            
            $param_str = ($properties_count == $param_substr_len) ? $param_substr : substr($param_substr, 0, -($param_substr_len-$properties_count));
            
            if ($database->query($sql, $param_str, array_values($properties)) == true) {
                return ($database->connection->affected_rows == -1) ? true : false;
            } else {
                return false;
            }

        }


        public function deleteAll($user_id) {

            global $database;

            $sql = "DELETE FROM " .static::$table. " WHERE `user_id` = ?";
            
            if ($database->query($sql, i, [$user_id]) == true) {
                $session = new Session();
                $session->logOut();
                return ($database->connection->affected_rows == -1) ? true : false;
            } else {
                return false;
            }

        }
        

    }


?>