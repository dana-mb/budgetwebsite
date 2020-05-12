<?php

    include("../includes/init.php");

    Session::start();
    
    if ($_POST['newCategoryName']) {
          
        $category = new Category($_POST['newCategoryName']);
        
        if($category->create() == true) {
        
            echo "ok";

        } else {
            echo "The category has not been added";
        }
    }
?>