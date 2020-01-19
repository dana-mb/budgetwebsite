<?php
    include("check_user_id.php");  
    
    if (($_POST['newCategoryName'])) {
          
        $stmt = $link->prepare("INSERT INTO `categories` (`user_id`, `category_name`) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $_POST['newCategoryName']);
        
        if ($stmt -> execute()) {
            echo "ok";
            $stmt->close();
        } else {
            echo "The category has not been added";
            $stmt->close();
        }
    }
    $stmt->close();
?>