<?php

    include("../includes/init.php");
    include("../link.php");
    
    // Table Scheme for expenses table
    Expense::create_table();

    session_start();
    if (($_POST['expenseAmount'])) {
        include("check_user_id.php");    
        $stmt = $link->prepare("INSERT INTO `expenses` (`user_id`, `amount`, `category_name`, `date`, `details`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("idsss", $user_id, $_POST['expenseAmount'], $_POST['categoryName'], date('Y-m-d', strtotime( $_POST['expenseDate'] )), $_POST['expenseDetails']);
        
        if ($stmt -> execute()) {
            echo "ok";
            exit;
        } else {
            echo "The expense has not been added";
            exit;
        };
    }
    exit;
?>