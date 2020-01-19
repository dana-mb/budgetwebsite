<?php
    session_start();
    if (($_POST['categoryName'])) {
        include("check_user_id.php");
        $budgetStartingDate = DateTime::createFromFormat('d-m-Y', "01-".$_POST['budgetStartingDate'])->format('Y-m-d');
        $output = '';

        $stmt = $link->prepare("DELETE FROM `budgets` WHERE `user_id` = ? AND `category_name` = ? AND `amount` = ? AND `budget_start_date` = ?");
        $stmt->bind_param("isis", $user_id, $_POST['categoryName'], $_POST['budgetAmount'], $budgetStartingDate);
        

        if ($stmt -> execute()) {
            $output = "ok";
            $stmt->close();
        } else {
            echo "The budget has not been deleted";
            $stmt->close();
        }

            //check to see how many budgets there are already for this category
            $stmt = $link->prepare("SELECT `budget_start_date` FROM `budgets` WHERE `user_id` = ? AND `category_name` = ? ORDER BY `budget_start_date`");
            $stmt->bind_param("is", $user_id, $_POST['categoryName']);
            $stmt->execute();
            $result = $stmt -> get_result();
            $budgetDates = array();
            
            while ($user = mysqli_fetch_assoc($result)) {
                $budgetDates[] = $user['budget_start_date'];
            }
            $stmt->close();
            
            if (count($budgetDates) > 0) {

                //to find the budget that's newer than the one we're deleting
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

                //to find the budget that's older than the one we're deleting
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
                    if ( $newerBudget != null ) {

                        $budgetEndingDate = date("Y-m-d",strtotime($newerBudget." -1 day"));
                        $stmt = $link->prepare("UPDATE `budgets` SET `budget_end_date` = ? WHERE `user_id` = ? AND `category_name` = ? AND `budget_start_date` = ?");
                        $stmt->bind_param("siss", $budgetEndingDate, $user_id, $_POST['categoryName'], $olderBudget);
                        
                        if ($stmt->execute()) {
                            $output = "ok";
                            $stmt->close();
                        } else {
                            echo "The budget has not been deleted";
                            exit;
                        }

                    } else {
                        $budgetEndingDate = NULL;
                        $stmt = $link->prepare("UPDATE `budgets` SET `budget_end_date` = ? WHERE `user_id` = ? AND `category_name` = ? AND `budget_start_date` = ?");
                        $stmt->bind_param("siss", $budgetEndingDate, $user_id, $_POST['categoryName'], $olderBudget);
                        
                        if ($stmt->execute()) {
                            $output = "ok";
                            $stmt->close();
                        } else {
                            echo "The budget has not been deleted";
                            exit;
                        }
                    }
                }   
            }
            echo $output;
    }
    $stmt->close();
?>