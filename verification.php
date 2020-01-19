<?php 

    include("link.php");
  
   // Table Scheme for users table
   $sql_users = "CREATE TABLE IF NOT EXISTS `users` (
            `user_id` int(11) NOT NULL AUTO_INCREMENT,
            `email` text NOT NULL,
            `unique_id` text NOT NULL,
            `password` text NOT NULL,
            `hashed_code` text NOT NULL,
            `verified_status` text NOT NULL,
            `token` text,
            PRIMARY KEY (`user_id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

    // Table Scheme for categories table
    $sql_categories = "CREATE TABLE IF NOT EXISTS `categories` (
        `category_id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `category_name` text NOT NULL,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
        PRIMARY KEY (`category_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

   
    $link->query($sql_users);
    $link->query($sql_categories);

   if(array_key_exists("sign-up", $_POST))
   {
        $stmt = $link->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $_POST['email']);
        $stmt->execute();
        $result = $stmt -> get_result();
        $user = $result->fetch_assoc();
        
        if ($result->num_rows ==  0) 
        {
            // prepare and bind
            $stmt = $link->prepare("INSERT INTO `users` (`email`,`unique_id`,`password`,`hashed_code`,`verified_status`) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $email, $unique_id, $pass, $hashed_code, $verified_status);

            // set parameters and execute
            $email=$_POST['email'];
            $unique_id=uniqid(rand(), true);
            $pass=password_hash($_POST['password'].$unique_id, PASSWORD_DEFAULT, ['cost' => 12]);
            $code=substr(md5(mt_rand()),0,15);
            $hashed_code=password_hash($code, PASSWORD_DEFAULT, ['cost' => 12]);
            $verified_status='unverified';
            $stmt->execute();
            
            $message = "Your Activation Code is ".$code."";
            $to=$email;
            $subject="Activation Code For the Budget Website";
            $from = "danamboyko@gmail.com";
            $body= "Your Activation Code is ".$code." Please Click On This link http://ec2-35-178-149-238.eu-west-2.compute.amazonaws.com/BudgetWebsite/verification.php?code=".$code."&email=".$email." to activate your account.";
            $headers = "From:".$from;
            mail($to,$subject,$body,$headers);
            
            
            $index_message = "An Activation Code Is Sent To You. Check Your Last Verification Email!";
            include("index.php");

            $stmt->close();
            $link->close();
            
        } else if ($user['verified_status'] == 'unverified') 
        { 
            $code = $user['hashed_code'];
            $email=$_POST['email'];

            $message = "Your Activation Code is ".$code."";
            $to=$email;
            $subject="Activation Code For the Budget Website";
            $from = "danamboyko@gmail.com";
            $body= "Your Activation Code is ".$code." Please Click On This link http://ec2-35-178-149-238.eu-west-2.compute.amazonaws.com/BudgetWebsite/verification.php?code=".$code."&email=".$email." to activate your account.";
            $headers = "From:".$from;
            mail($to,$subject,$body,$headers);
            
            
            $index_message = "An Activation Code Is Sent To You. Check Your Last Verification Email!";
            include("index.php");

            $stmt->close();
            $link->close();

        } else if ($result->num_rows != 0 && $user['verified_status'] == 'verified')
        {
            $index_message = "The user already exist on this site, try to log in!";
            include("index.php");
        }
   }
   // verifying the email
   if(isset($_GET['code']) && isset($_GET['email']))
   {
       $email=$_GET['email'];
       $code=$_GET['code'];
       
       $stmt = $link->prepare("SELECT * FROM `users` WHERE email=?");
       $stmt->bind_param("s", $email);
       $stmt -> execute();
       $result = $stmt -> get_result();
       $user = $result->fetch_assoc();
       

       //if the user is verified write that he's verified in the users table
       if($result->num_rows == 1 && password_verify($code, $user['hashed_code']))
       {
           $stmt = $link->prepare(
               "UPDATE `users`
                SET `hashed_code`=?,`verified_status`=?
                WHERE `email`=?" );

            $stmt-> bind_param("sss", $new_code, $verified_status, $email);
            $new_code= '0';
            $verified_status= 'verified';

            if($stmt -> execute()) 
            {
                $index_message= "<h3>Your sign up was successful, You may now log in!</h3>";
                //include("index.php");
                
                //insert new categories into the category list for the new user
                $stmt = $link->prepare("INSERT INTO `categories` (`user_id`,`category_name`) VALUES (?,?)");
                
                function insertCategory($user_id, $category_name) {
                    global $stmt;
                
                    // using prepared statement several times with different variables
                    if (
                        $stmt &&
                        $stmt -> bind_param('ss', $user_id, $category_name) &&
                        $stmt -> execute()
                    ) {
                         // new category for the user added
                    }
                
                }

                // set parameters and execute
                insertCategory($user['user_id'], 'Groceries');
                insertCategory($user['user_id'], 'Going out');
                insertCategory($user['user_id'], 'Vacation');
                insertCategory($user['user_id'], 'Dog care');
                insertCategory($user['user_id'], 'Gifts');
                
            }
            else 
            {
                echo "unsuccessful_signup";
            }   
       } else if ($user['verified_status'] == 'unverified')
        {
            $index_message= "Your sign up was unsuccessful, please sign up again and verify your email with the last email that is sent to you.";
            include("index.php");
        } else 
        {
            header ("Location: index.php");
        }
       
        $stmt->close();
        $link->close();
   }

    $stmt->close();
    $link->close();
   
?>