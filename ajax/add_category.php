<?php

    include("../includes/init.php");

    Session::start();
    
    if ($_POST['newCategoryName']) {
          
        $category = new Category($_POST['newCategoryName']);
        
        if($category->create(is) == true) {
        
            echo "ok";

        } else {
            echo "The category has not been added";
        }
    }
?>