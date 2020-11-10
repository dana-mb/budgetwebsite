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
                // properties.
                // loop through each row seperetly and instantiate the values like 
                // $row['username']" to the properties of the class 
                $the_object_array[] = static::instantation($row); 

            }

            return $the_object_array; 
        }


        public static function instantation($the_record) {

            // get the key and the value from the row from the DB
            foreach ($the_record as $the_attribute => $value) {

                // check if the key exist as a property(attribute) in the object 
                if($the_object->has_the_attribute($the_attribute)) {

                    // assign the value from the row to the property of the class
                    $the_object->$the_attribute = $value;

                }
            }
            return $the_object;
        }

        // check if the key exist as a property(attribute) in the object 
        private function has_the_attribute($the_attribute) {
            // get_object_vars returns all the properties from the class even if they're private
            $object_properties = get_object_vars($this);
            return array_key_exists($the_attribute, $object_properties);
        }


        protected function properties() {
            $properties = array();
            // take each item from the variable array 'table_fields' from the class
            foreach (static::$table_fields as $table_field) {
                // check if the item exist as property in $this- the class. 
                // if it does exist and has a value (not empty) 
                //  AND !empty($this->$table_field)
                if(property_exists($this, $table_field) AND !empty($this->$table_field)) { 
                    // it will be assign to $property array
                    $properties [$table_field] = $this->$table_field; 
                }
            }
            return $properties;
        }


        public function create() {
            global $database;

            // get all the properties that has been assigned a value
            $properties = $this->properties();

            $sql = "INSERT INTO " .static::$table. "(" . implode( ",", array_keys($properties) ) . ")";
            
            //apply all the values to our object, except the auto incremented id:
            
            $sql .= " VALUES (".implode( ",", array_fill(0, count($properties), '?') ).") ";
            
            $param = array_values($properties);

            // get the parameters type from the variable 'table_param_t' in the class and make it a string
            $param_type_str = static::$table_param_t;
            $param_type_str_len = strlen($param_type_str);
            // get the number of properties
            $properties_count = sizeof($properties);
            
            // if the param type lenght is more than the number of properties than remove the last letters from parameter kind 
            // that's because not all the properties are neccesary (when entering an expense the details prop' is not mendatory)
            $param_str = ($properties_count == $param_type_str_len) ? $param_type_str : substr($param_type_str, 0, -($param_type_str_len-$properties_count));

            if($database->query($sql, $param_str, $param) == true) {
                return ($database->connection->affected_rows == -1) ? true : false;

                //estantiate the class, assigned static strings for the object(username..)
            } else {
                return false;
            }
        }


        public function update($tableField, $new_value, $param_kind) {

            global $database;
            $properties = $this->properties();
            $properties_pairs = array();

            foreach ($properties as $key => $value) {

                $properties_pairs[] = " `{$key}` = ? "; // single quotes for the strings
                
            }

            $sql = "UPDATE " .static::$table. " SET ";
            $sql .= " `{$tableField}` = ? ";
            $sql .= " WHERE ";                  // make sure to have a space before the where, 
            $sql .= implode( " AND ", $properties_pairs );

            // get all the values from properties
            $param = array_values($properties);
            // insert new array value (the value to update to) to the beginning of the array
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

                $properties_pairs[] = " `{$key}` = ? "; // single quotes for the strings
                
            }
            $sql .= implode( "AND", $properties_pairs );
            
            // get the parameters type from the variable 'table_param_t' in the class and make it a string
            $param_type_str = static::$table_param_t;
            $param_type_str_len = strlen($param_type_str);
            // get the number of properties
            $properties_count = sizeof($properties);
            
            // if the param type lenght is more than the number of properties than remove the last letters from parameter kind 
            // that's because not all the properties are neccesary (when entering an expense the details prop' is not mendatory)
            $param_str = ($properties_count == $param_type_str_len) ? $param_type_str : substr($param_type_str, 0, -($param_type_str_len-$properties_count));
            
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