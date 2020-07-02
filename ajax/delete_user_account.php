<?php

    include("../includes/init.php");
    Session::start();
    
    $user = new User();
    if($user->delete_user()) {
        echo "ok";
    } else {
        echo "An error occured. The account could not be deleted.";
    }


?>