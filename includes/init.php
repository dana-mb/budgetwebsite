<?php
    
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    
    /* use PHPMailer\PHPMailer\SMTP; // added from the simple example script
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;
 */
    /* require_once("Exception.php");
    require_once("PHPMailer.php");
    require_once("SMTP.php"); */
    
    include("variables_to_ignore.php");
    require_once("mailer.php");
    require_once("config.php");
    require_once("database.php");
    require_once("db_object.php");
    
    require_once("user.php");
    require_once("category.php");
    require_once("session.php");
    require_once("expense.php");
    require_once("budget.php");
    require_once("dashboard.php");


    
    

    
?>