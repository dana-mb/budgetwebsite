<?php
include("../includes/init.php");
session_start();
    if ($_POST['budgetAmount']) {
        $budgetStartingDate = date('Y-m-d', strtotime( $_POST['budgetStartingDate'] ));
        $dateInShort = DateTime::createFromFormat('Y-m', $_POST['budgetStartingDate'])->format('m-Y');
        include("check_user_id.php");

        //check to see if there is already a budget that starts on the same date
        $stmt = $link->prepare("SELECT * FROM `budgets` WHERE `user_id` = ? AND `category_name` = ? AND `budget_start_date` = ?");
        $stmt->bind_param("iss", $user_id, $_POST['categoryName'], $budgetStartingDate);
        $stmt->execute();
        $result = $stmt -> get_result();

        if($result->num_rows == 0) {
            $stmt->close();
            //check to see how many budgets there are already for this category
            $stmt = $link->prepare("SELECT `budget_start_date` FROM `budgets` WHERE `user_id` = ? AND `category_name` = ? ORDER BY `budget_start_date`");
            $stmt->bind_param("is", $user_id, $_POST['categoryName']);
            $stmt->execute();
            $result = $stmt -> get_result();
            $budgetDates = array();
            $output = '';
            while ($user = mysqli_fetch_assoc($result)) {
                $budgetDates[] = $user['budget_start_date'];
            }
            $stmt->close();
            
            if (count($budgetDates) > 0) {
                //to find the budget that's newer than the new one
                $i = 0;
                while($i < count($budgetDates))
                {
                    if($budgetDates[$i] < $budgetStartingDate) 
                    {
                        $i++;
                    }
                    else 
                    {
                        $newerBudget = $budgetDates[$i];
                        break;
                    }
                }
                
                if ( $newerBudget != null )
                {
                    $budgetEndingDate = date("Y-m-d",strtotime($newerBudget." -1 day"));
                    $stmt = $link->prepare("INSERT INTO `budgets` (`category_name`, `user_id`, `amount`, `budget_start_date`, `budget_end_date`) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("siiss", $_POST['categoryName'], $user_id, $_POST['budgetAmount'], $budgetStartingDate, $budgetEndingDate);
                
                    if ($stmt->execute()) {
                        $output = "ok";
                    } else {
                        echo "The budget has not been added".$budgetEndingDate;
                        exit;
                    }
                }
                //to find the budget that's older than the new one
                $i = count($budgetDates)-1;
                while($i >= 0)
                {
                    if($budgetDates[$i] > $budgetStartingDate) 
                    {
                        $i--;
                    }
                    else 
                    {
                        $olderBudget = $budgetDates[$i];
                        break;
                    }
                }

                if ( $olderBudget != null )
                {
                    $olderBudgetEndDate = date("Y-m-d",strtotime($budgetStartingDate." -1 day"));
                    $stmt = $link->prepare("UPDATE `budgets` SET `budget_end_date` = ? WHERE `user_id` = ? AND `category_name` = ? AND `budget_start_date` = ?");
                    $stmt->bind_param("siss", $olderBudgetEndDate, $user_id, $_POST['categoryName'], $olderBudget);
                    
                    if ($stmt->execute()) {
                        $output = "ok";
                    } else {
                        echo "The budget has not been added";
                        exit;
                    }
                }
            }
            //add the budget with no ending date when there is no newer budget for this category, because if there is the budget was already inserted with an ending date
            if ($newerBudget == null)
            {
                $stmt = $link->prepare("INSERT INTO `budgets` (`category_name`, `user_id`, `amount`, `budget_start_date`) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("siis", $_POST['categoryName'], $user_id, $_POST['budgetAmount'], $budgetStartingDate);
                
                if ($stmt->execute()) {
                    $output = "ok";
                } else {
                    echo "The budget has not been added";
                    exit;
                }
            }
            echo $output;

        } else {
            echo "There is already a budget that starts off from ".$dateInShort." for the category ".$_POST['categoryName'];
        }
        
    exit;
    }
    
?>