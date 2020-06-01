<?php

    require_once("includes/init.php");
    Session::start();

    $userArray = new User();
    $userArray = $userArray->find_user_by_email($_POST['email']);

    if( password_verify($_POST['password'].$userArray[0]->unique_id, $userArray[0]->password) )
    {
        // set parameters and execute
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
            header ("Location: budget_dashboard.php");
        
        } else 
        {
            if( $_SESSION['budget_website_session'] = $cookie) 
            {
                header ("Location: budget_dashboard.php");
            }   
        }
    } 
    else
    {
        $index_message = "Login failed. Check the email-password combination and try again!";
        include("index.php");
    }

    $session = new Session();
    $session->session_and_cookie_check();
?>