<?php

session_start();

include("link.php");


$stmt = $link->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $_POST['email']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if( password_verify($_POST['password'].$user['unique_id'], $user['password']) ) 
{
    // prepare and bind
    $stmt = $link->prepare("
        UPDATE `users`
        SET `token`=?
        WHERE `email`=? AND `password`=? ");
    $stmt->bind_param("sss", $hashed_token, $email, $password);

    // set parameters and execute
    $token= bin2hex(random_bytes(16));
    $hashed_token= password_hash( $token, PASSWORD_DEFAULT, ['cost' => 12] );
    $email= $user['email'];
    $password= $user['password'];
    $stmt -> execute();
    
    $cookie = $user['unique_id']."-".$token;
    echo $cookie;

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

include("check_sessions&cookies.php");
?>  