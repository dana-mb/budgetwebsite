<?php

    include("../includes/init.php");

    session_start();
    if (($_POST['expenseAmount'])) {
        
        if(Expense::add_new_expense(
                        $_POST['expenseAmount'], $_POST['categoryName'], 
                        date('Y-m-d', strtotime( $_POST['expenseDate'] )), 
                        $_POST['expenseDetails']) == true
        
        ) {
            echo "ok";
            exit;
        } else {
            echo "The expense has not been added";
            exit;
        };
    }
    exit;
?>