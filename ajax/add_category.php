<?php

    include("../includes/init.php");

    session_start();
    
    if (($_POST['newCategoryName'])) {
          
        if(Category::add_new_category($_POST['newCategoryName']) == true) {
        
            echo "ok";

        } else {
            echo "The category has not been added";
        }
    }
?>