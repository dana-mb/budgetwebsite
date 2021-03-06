<?php

    class Session extends User {

        public static function start() {
            session_start();
        }

        public function session_and_cookie_check() {
            $url_file_name = basename($_SERVER['SCRIPT_NAME']);
            // //when there is a session or a cookie for the website- check if it is good-
            // //if so and the user is not inside the website get him into the home page
            if ( NULL !== $_SESSION['budget_website_session'] OR NULL !== $_COOKIE['budget_website_cookie'] )
            {
                $this->find_user_info();
                if (password_verify($this->user_computer_token, $this->user_db_token))
                {
                    if (strpos($url_file_name,'budget') == 0) { //actually it's =0 because it's the first occurance of 'budget' in the string
                        //stay in the page
                    } else {
                        header ("Location: budget_dashboard.php");
                    }
                } else {
                    $this->logOut();
                }   
            } 
            
            // if the user is already in the website and is logging out the website 
            // (the cookies and the session has been erased)- the user is moved to the logging-in page
            else if ( $url_file_name !== "index.php" && 
                    empty($index_message) && 
                    NULL === $_SESSION['budget_website_session'] && 
                    NULL === $_COOKIE['budget_website_cookie'] )
            {
                header ("Location: index.php");
            }
        }

        public function logOut() {
            unset($_SESSION['budget_website_session']);
            session_destroy();
            unset($_COOKIE['budget_website_cookie']);
            setcookie('budget_website_cookie', '', time() - 3600, '/');
            header("Location: index.php");
        }

    
    }

?>