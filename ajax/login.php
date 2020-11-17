<?php

    require_once("../includes/init.php");
    Session::start();

    // Table Scheme for users table
    User::create_table();

    // Table Scheme for categories table
    Category::create_table();

    // Table Scheme for budgets table
    Budget::create_table();

    // Table Scheme for expenses table
    Expense::create_table();
    
    $userArray = new User();
    $userArray = $userArray->find_user_by_email($_POST['email']);

    if ($userArray != null) {

        if( $userArray[0]->verified_status == 'verified' || $userArray[0]->verified_status == 'forgot password' ) {

            if( password_verify($_POST['password'].$userArray[0]->unique_id, $userArray[0]->password) )
            {
                if ($userArray[0]->verified_status == 'forgot password') {
                    $user1 = new User($_POST['email']);
                    $user1->update('verified_status','verified','ss');
                }

                $token= bin2hex(random_bytes(16));
                $hashed_token= password_hash( $token, PASSWORD_DEFAULT, ['cost' => 12] );
                $email= $_POST['email'];
                $password= $_POST['password'];
                
                $user = new User($email);
                $user->update('token',$hashed_token,'ss');
                
                $cookie = $userArray[0]->unique_id."-".$token;

                if ( isset($_POST['stayLoggedIn']) && !isset($_COOKIE['budget_website_cookie']) ) 
                {
                    setcookie('budget_website_cookie', $cookie, time() + 60 * 60, "/"); // usually time() + 60 * 60 * 24 * 14
                    $_SESSION['budget_website_session'] = $cookie;
                    echo "ok";
                
                } else 
                {
                    if( $_SESSION['budget_website_session'] = $cookie) 
                    {
                        echo "ok";
                    }   
                }
            } 
            else
            {
                echo "Login failed. Check the email-password combination and try again!";
            }
        
        } else {
            echo "Login failed. The user is not verified in the system.<br>Check for the verification email in your mail or try to sign up again in order to send another one.";
        }
    
    } else {
        echo "The email is not registered in the website. Please sign up and try again.";
    }

?>