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
   

   if(!empty($_POST["password"]))
   {
        $userArray = new User();
        $userArray = $userArray->find_user_by_email($_POST['email']);
        if($userArray == null)
        {
            $email=$_POST['email'];
            $unique_id=uniqid(rand(), true);
            $pass=password_hash($_POST['password'].$unique_id, PASSWORD_DEFAULT, ['cost' => 12]);
            $code=substr(md5(mt_rand()),0,15);
            $hashed_code=password_hash($code, PASSWORD_DEFAULT, ['cost' => 12]);
            $verified_status='unverified';
            
            $user = new User($email, $unique_id, $pass, $hashed_code, $verified_status);
            if ($user->create() == 'true')
            {
                $email = filter_var($email, FILTER_VALIDATE_EMAIL); // Preventing Email Injection

                if ($email === FALSE) {
                    echo 'Invalid email';
                    exit;
                }
                
                $subject = "Activation Code For the Budget Website";
                // $subject = str_ireplace(array("\r", "\n", '%0A', '%0D'), '', $subject); // Preventing Email Injection
                $local= "Your Activation Code is ".$code." Please Click On This link http://localhost/budgetwebsite/index.php?code=".$code."&email=".$email." to activate your account.";
                $web_server = "Your Activation Code is ".$code." Please Click On This link  ".WEB_SERVER_LINK."/index.php?code=".$code."&email=".$email." to activate your account.";
                $body = $_SERVER['HTTP_HOST'] == 'localhost' ? $local : $web_server;
                // $body = str_replace("\n.", "\n..", $body); // Preventing Email Injection

                $mailer = new Mailer();
                if ($mailer -> send_smtp_mail($subject , $body , EMAIL_FROM, $email)) {

                    echo "An Activation Code Is Being Sent To You. Check Your Verification Email!";
                    exit;

                } else {
                    echo "The mail wasn't being send to you"; 
                    exit;
                }

            } else {
                echo "The user created in the database";
            }

        } else if ($userArray[0]->verified_status == 'unverified') 
        { 
            
            $email=$_POST['email'];
            
            $unique_id=uniqid(rand(), true);
            $pass=password_hash($_POST['password'].$unique_id, PASSWORD_DEFAULT, ['cost' => 12]);
            
            $code=substr(md5(mt_rand()),0,15);
            $hashed_code=password_hash($code, PASSWORD_DEFAULT, ['cost' => 12]);

            $user = new User($email);
            
            if ($user->update('unique_id',$unique_id,'ss') == 'true' && $user->update('hashed_code',$hashed_code,'ss') == 'true' && $user->update('password',$pass,'ss') == 'true')
            {
                $email = filter_var($email, FILTER_VALIDATE_EMAIL); // Preventing Email Injection

                if ($email === FALSE) {
                    echo 'Invalid email';
                    exit;
                }

                $subject = "Activation Code For the Budget Website";
                $subject = str_ireplace(array("\r", "\n", '%0A', '%0D'), '', $subject); // Preventing Email Injection
                $local= "Your Activation Code is ".$code." Please Click On This link http://localhost/budgetwebsite/index.php?code=".$code."&email=".$email." to activate your account.";
                $web_server = "Your Activation Code is ".$code." Please Click On This link  ".WEB_SERVER_LINK."/index.php?code=".$code."&email=".$email." to activate your account.";
                $body = $_SERVER['HTTP_HOST'] == 'localhost' ? $local : $web_server;
                $body = str_replace("\n.", "\n..", $body); // Preventing Email Injection
                
                $mailer = new Mailer();
                if ($mailer -> send_smtp_mail($subject , $body , EMAIL_FROM, $email)) {
                
                    echo "An Activation Code Has Been Sent To You Again. Check Your Last Verification Email!";
                    exit;
                
                } else {
                    echo "There was a problem in sending another activation code, but it Was Already Sent To You. Check Your Last Verification Email!";
                }
            }

        } else if ($userArray != null && $userArray[0]->verified_status == 'verified')
        {
            echo "The user is already exist on this site, try to log in!";
        }
   }
   // verifying the email
   if(isset($_POST['getCode']) && isset($_POST['getEmail']))
   {
        $email=$_POST['getEmail'];
        $code=$_POST['getCode'];

        $userArray = New User();
        $userArray = $userArray->find_user_by_email($email);

        if($userArray[0]->verified_status == 'unverified') {

            //if the user is verified write that he's verified in the users table
            if($userArray != null && password_verify($code, $userArray[0]->hashed_code))
            
            {
                    $user = new User($email);
                    
                    $new_code= '0';
                    $verified_status= 'verified';
                    
                    
                    if ($user->update('hashed_code',$new_code,'ss') == 'true' && $user->update('verified_status',$verified_status,'ss') == 'true')
                    
                    {
                        
                        echo "Your sign up was successful, You may now log in!";
                        
                        //insert new categories into the category list for the new user
                        
                        $categories = array('Groceries','Going out','Vacation','Dog care','Gifts');
                        foreach ($categories as $category) 
                        {
                            $newCategory = new Category( $userArray[0]->user_id, $category );
                            
                            $newCategory->create();

                        }
                    }
                    else 
                    {
                        echo "unsuccessful_signup";
                    }   
            } else if ($userArray->verified_status == 'unverified')
                {
                    echo "Your sign up was unsuccessful, please sign up again and verify your email with the last email that is sent to you.";
                } 
        
        } 
   }

   
?>