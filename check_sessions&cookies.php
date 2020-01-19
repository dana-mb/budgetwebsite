<?php

session_start();

include ("link.php");

$url_file_name = basename($_SERVER['SCRIPT_NAME']);

//when there is a session for the website- check if the session is good-
//if so and the user is not inside the website get him into the home page
if ( NULL !== $_SESSION['budget_website_session']) 
{
    list($unique_id,$token)=explode("-", $_SESSION['budget_website_session']);
     
    $stmt = $link->prepare("SELECT * FROM users WHERE unique_id = ?");
    $stmt->bind_param("s", $unique_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $user_id = $user['user_id'];

    if (password_verify($token, $user['token']))    
    {
      if (strpos($url_file_name,'budget') !== false) 
      {
        //do nothing, stay in the page
      } 
      else 
      {
        header ("Location: budget_dashboard.php");
      }
    }
    $stmt->close();
} 
//when there is a cookie for the website- check if the cookie is good-
//if so and the user is not inside the website get him into the home page
else if ( NULL !== $_COOKIE['budget_website_cookie']) 
{
    list($unique_id,$token)=explode("-", $_COOKIE['budget_website_cookie']);
    
    $stmt = $link->prepare("SELECT * FROM users WHERE unique_id = ?");
    $stmt->bind_param("s", $unique_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $user_id = $user['user_id'];
    
    if (password_verify($token, $user['token']))
    {
      if (strpos($url_file_name,'budget') !== false) 
      {
        //do nothing, stay in the page
      } 
      else 
      {
        header ("Location: budget_dashboard.php");
      }
    }
    $stmt->close();
} 
//if the user is already in the website and is logging out the website 
//(the cookies and the session has been erased)- the user is moved to the logging-in page
else if ( $url_file_name !== "index.php" && 
          empty($index_message) && 
          NULL == $_SESSION['budget_website_session'] && 
          NULL == $_COOKIE['budget_website_cookie'] )

{
    header ("Location: index.php");
}

?>