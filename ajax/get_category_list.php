<?php
    include("check_user_id.php");  
    
    $stmt = $link->prepare("SELECT `category_name` FROM `categories` WHERE `category_id`= (SELECT MAX(`category_id`) FROM `categories` WHERE user_id = ?)");
                                $stmt->bind_param("i", $user_id);
        
    if ($stmt -> execute()) {
        $result = $stmt -> get_result();
        while($user = $result->fetch_assoc())
        {   
            $categoryName = $user['category_name'];
            $categoryNameId = str_replace(' ', '-', $categoryName); 

            echo("<li><input type='radio' name='category' id=".$categoryNameId." value='".$categoryName."'><label for=".$categoryNameId.">".$categoryName."</label><div class='deleteMe'>X</div></li>");
            
        }
        
        $stmt->close();
    } else {
        echo "The list can't be reloaded";
        $stmt->close();
    }
    
?>