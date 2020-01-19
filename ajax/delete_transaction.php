<?php
    session_start();
    if (($_POST['categoryName'])) {
        include("check_user_id.php");

        $stmt = $link->prepare("DELETE FROM `expenses` WHERE `user_id` = ? AND `category_name` = ? AND `amount` = ? AND `date` = ?");
        $stmt->bind_param("isds", $user_id, $_POST['categoryName'], $_POST['expenseAmount'], $_POST['expenseDate']);
        

        if ($stmt -> execute()) {
            echo "ok";
            $stmt->close();
        } else {
            echo "The expense has not been deleted";
            $stmt->close();
        }

            
    }
    $stmt->close();
?>