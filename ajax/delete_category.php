<?php
    session_start();
    if (($_POST['categoryName'])) {
        include("check_user_id.php");    
        $stmt = $link->prepare("DELETE FROM `categories` WHERE `user_id` = ? AND `category_name` = ?");
        $stmt->bind_param("is", $user_id, $_POST['categoryName']);
        
        if ($stmt -> execute()) {
            echo "ok";
            $stmt->close();
        } else {
            echo "The category has not been deleted";
            $stmt->close();
        }
    }
    $stmt->close();
?>