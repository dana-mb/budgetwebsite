<?php
    include("../includes/init.php");
    Session::start();
    
    if ($_POST['categoryName']) {
        
        $category = new Category(null, $_POST['categoryName']);

        if ($category->delete() == 'true') {
            echo "ok";
        } else {
            echo "The category has not been deleted";
        }
    }
?>