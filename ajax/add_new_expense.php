<?php

    include("../includes/init.php");

    Session::start();
    if (($_POST['expenseAmount'])) {
        
        $expense = new Expense($_POST['expenseAmount'], $_POST['categoryName'], 
                         date('Y-m-d', strtotime( $_POST['expenseDate'] )), 
                         $_POST['expenseDetails']);
        
        // if($expense->create([
        //                 $_POST['expenseAmount'], $_POST['categoryName'], 
        //                 date('Y-m-d', strtotime( $_POST['expenseDate'] )), 
        //                 $_POST['expenseDetails'] ]) == true) {
        if($expense->create() == true) {
            echo "ok";
            exit;
        } else {
            echo "The expense has not been added";
            exit;
        };
    }
    exit;
?>