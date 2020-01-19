<?php

    include("../link.php");
    
    // Table Scheme for expenses table
        $sql_expenses = "CREATE TABLE IF NOT EXISTS `expenses` (
            `expense_id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `amount` DECIMAL (8, 2) NOT NULL,
            `category_name` text NOT NULL,
            `date` date NOT NULL,
            `details` text,
            FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
            PRIMARY KEY (`expense_id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

    $link->query($sql_expenses);

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