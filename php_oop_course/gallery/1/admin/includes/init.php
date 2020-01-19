<?php 

    // define DIRECTORY_SEPARATOR- a constant - backsplash in windows (\) if not exist
    defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR); 
    
    defined('SITE_ROOT') ? null : define( 'SITE_ROOT', DS. 'var' .DS. 'www' .DS. 'html' .DS. 'BudgetWebsite' .DS. 'php_oop_course' .DS. 'gallery' .DS. '1' );

    defined('INCLUDES_PATH') ? null : define( 'INCLUDES_PATH', SITE_ROOT.DS. 'admin' .DS. 'includes' );
    
    
    require_once("functions.php"); //require_once more secure gives us a big failer not just a message 
    require_once("new_config.php");
    require_once("database.php");
    require_once("db_object.php");
    require_once("user.php");
    require_once("comment.php");
    require_once(__DIR__ . DS . "photo.php"); //so that we include the right class file by the include of init inside photo.php and not include the same file. thay have the same name.
    require_once("session.php");

?>