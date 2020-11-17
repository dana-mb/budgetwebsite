<?php

    require_once("../includes/init.php");
    Session::start();

  
    if($_POST['email']) {

        $email = $_POST['email'];
        
        $code=substr(md5(mt_rand()),0,15);
        
        $hashed_code=password_hash($code, PASSWORD_DEFAULT, ['cost' => 12]);
        
        $user = new User($email);
        
        if ($user->update('hashed_code',$hashed_code,'ss') == 'true' && $user->update('verified_status','forgot password','ss') == 'true') {
            
            $email = filter_var($email, FILTER_VALIDATE_EMAIL); // Preventing Email Injection

            if ($email === FALSE) {
                echo 'Invalid email';
                exit;
            }

            $subject="Resetting Your Password For the Budget Website";
            $subject = str_ireplace(array("\r", "\n", '%0A', '%0D'), '', $subject); // Preventing Email Injection
            $local = "Please Click On This link http://localhost/budgetwebsite/index.php?code-for-new-password=".$code."&email-for-new-password=".$email."#overlay to reset your password.";
            $web_server = "Please Click On This link ".WEB_SERVER_LINK."index.php?code-for-new-password=".$code."&email-for-new-password=".$email."#overlay to reset your password.";
            $body = $_SERVER['HTTP_HOST'] == 'localhost' ? $local : $web_server;
            $body = str_replace("\n.", "\n..", $body); // Preventing Email Injection
            
            $mailer = new Mailer();
            if ($mailer -> send_smtp_mail($subject, $body, "danamboyko@gmail.com", $email)) {
            
                echo "An email with a link to reset your password has been sent to you. Check your email!";
                exit;
            
            } else {
                echo "There was a problem in sending the email.";
            }
        }

    } else if($_POST['getEmail']) {

        $email = $_POST['getEmail'];
        $code = $_POST['getCode'];
        $password = $_POST['password'];

        $userArray = New User();
        $userArray = $userArray->find_user_by_email($email);
        $unique_id = $userArray[0]->unique_id;

        if ($userArray[0]->verified_status == 'forgot password') {
        
            if($userArray != null && password_verify($code, $userArray[0]->hashed_code)) {
            
                $hashed_password = password_hash($password.$unique_id, PASSWORD_DEFAULT, ['cost' => 12]);
                $new_code= '0';
                $verified_status= 'verified';

                $user = new User($email);
                
                if ($user->update('password',$hashed_password,'ss') == 'true' && $user->update('hashed_code',$new_code,'ss') == 'true' && $user->update('verified_status',$verified_status,'ss') == 'true') {
        
                    echo "ok";
                }

            } else {
                echo 'wrong code';
            }

        } else if ($userArray[0]->verified_status == 'verified') {
            echo 'verified';
        }
    }

?>