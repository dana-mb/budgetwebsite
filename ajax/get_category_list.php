<?php
    include("../includes/init.php");
    Session::start();

    //add the last category that was inserted to the list
    $category = new Category();
    $categoryName = $category->find_last_inserted_category()[0]->category_name;
    if($categoryName != null) {   
        
        $categoryNameId = str_replace(' ', '-', $categoryName); 
        echo("<li><input type='radio' name='category' id=".$categoryNameId." value='".$categoryName."'><label for=".$categoryNameId.">".$categoryName."</label><div class='deleteMe'>X</div></li>");
            
    } else {
        echo "The last category name can't be reloaded";
    }
    
?>