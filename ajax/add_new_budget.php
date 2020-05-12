<?php
include("../includes/init.php");
Session::start();

    if ($_POST['budgetAmount']) {
        $budgetStartingDate = date('Y-m-d', strtotime( $_POST['budgetStartingDate'] ));
        $dateInShort = DateTime::createFromFormat('Y-m', $_POST['budgetStartingDate'])->format('m-Y');

        //check to see if there is already a budget that starts on the same date
        $budget = new Budget();
        if($budget->find_user_budgets_from_x_category_and_date($_POST['categoryName'], $budgetStartingDate) == null) {
            
            //check to see how many budgets there are already for this category
            $budget1 = new Budget();
            $results = $budget1->find_budgets_start_date_from_x_category_order_by_date($_POST['categoryName']);
            $budgetDates = array();
            $output = '';
            foreach ($results as $result) {
                $budgetDates[] = $result->budget_start_date;
            };

            if (count($budgetDates) > 0) {
                //to find the budget that's newer than the one we are creating
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
                    
                    $budget2 = new Budget($_POST['categoryName'], $_POST['budgetAmount'], $budgetStartingDate, $budgetEndingDate);
                    if ($budget2->create() == 'true') {
                        $output = "ok";
                    } else {
                        echo "The budget has not been added";
                        exit;
                    }
                }
                //to find the budget that's older than the one we are creating
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

                    $budget3 = new Budget($_POST['categoryName'], null, $olderBudget);
                    if ($budget3->update('budget_end_date',$olderBudgetEndDate,'ssis') == 'true') {
                        $output = "ok";
                    } else {
                        echo "The budget has not been added (update)";
                        exit;
                    }
                }
            }
            // add the budget with no ending date when there is no newer budget for this category, because if there is the budget was already inserted with an ending date
            if ($newerBudget == null)
            {
                $budget4 = new Budget($_POST['categoryName'], $_POST['budgetAmount'], $budgetStartingDate);

                if ($budget4->create() == 'true') {
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