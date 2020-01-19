<?php

    class Photo extends Db_object {

        protected static $db_table = "photos"; //abstract attribute
        protected static $db_table_fields = array('title','caption', 'description','filename','alternate_text', 'type','size'); 
        public $id;
        public $title;
        public $caption;
        public $description;
        public $filename;
        public $alternate_text;
        public $type;
        public $size;

        public $tmp_path;
        public $upload_directory = "images";
        public $errors = array();//  in case that we move our pic from temp path to 
                                        // permanent path(our directory) & there is a problem.
                                        // we just put our errors in there and then display
                                        // it back to the user
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

        // method that will set values. it will take superglobal keys&values
        // and assign it to our object properties

        // this is passing $_FILES['uploaded_file'] as an argument

        public function set_file($file) {

            if( empty($file) || !$file || !is_array($file) ) { //if there is no file
                $this->errors[] = "there was no file uploaded here"; //save the error in error array so we can display it later
                return false;

            }elseif ($file['error'] != 0) { //if there is a file but there is an error

                $this->errors[] = $this->upload_errors_array[ $file['error'] ]; //save the error in error array so we can display it later
                return false;

            } else {

                $this->filename = basename($file['name']); // $file=$_FILES, basename- it gives only the filename & escape
                                                        // the original name of the file which you have uploaded from the user computer
                $this->tmp_path = $file['tmp_name']; // the name of your file content- on the website server. the default naming done by PHP.
                $this->type     = $file['type'];
                $this->size     = $file['size'];

            }
            
        }


        public function picture_path() {

            return $this->upload_directory.DS.$this->filename;

        }


        public function save() {

            if(isset($this->id)) { //if the is exist only do an update
                
                $this->update();
            
            } else {

                if( !empty($this->errors) ) { // if there are errors return false
                    return false;
                }

                if( empty($this->filename) || empty($this->tmp_path) ) { // if the file/tmp_path is empty put the string in the errors array
                    $this->errors[] = "the file was not available";
                    return false;
                }

                // create our target path (permanent location) with our filename (make sure this is writable)
                $target_path = SITE_ROOT .DS. 'admin' .DS. $this->upload_directory .DS. $this->filename;

                if( file_exists($target_path) ) {

                    $this->errors[] = "the file {$this->filename} already exists";
                    return false;

                }

                // move_uploaded_file(filename, destination) valid upload file 
                // (meaning that it was uploaded via PHP's HTTP POST upload mechanism).
                if( move_uploaded_file($this->tmp_path, $target_path) ) {

                    if( $this->create() ) { // if its ok then create it according to move_uploaded_file

                        unset($this->tmp_path); // because we dont need it anymore
                        return true;
                    
                    }

                } else {

                    $this->errors[] = "the file directory probably does not have permission";
                    return false;

                }

            }

        }


        public function delete_photo() {

            if ($this->delete()) {

                $target_path = SITE_ROOT.DS. 'admin' .DS. $this->picture_path();

                return unlink($target_path) ? true : false;
                
            } else {

                return false;

            }

        }


    }


?>