<?php
    include("../includes/init.php");
    Session::start();

    if (($_POST['categoryName'])) {
        
        $expense = new Expense($_POST['expenseAmount'], $_POST['categoryName'], $_POST['expenseDate']);

        if ($expense->delete() == 'true') {
            echo "ok";
        } else {
            echo "The expense has not been deleted";
        }       
    }
?>