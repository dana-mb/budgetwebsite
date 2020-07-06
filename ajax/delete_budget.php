<?php
    include("../includes/init.php");
    Session::start();

    if ($_POST['categoryName']) {
        $budgetStartingDate = DateTime::createFromFormat('d-m-Y', "01-".$_POST['budgetStartingDate'])->format('Y-m-d');
        $output = '';

        $budget = new Budget($_POST['categoryName'], $_POST['budgetAmount'], $budgetStartingDate);
        if ($budget->delete() == 'true') {
            $output = "ok";
        } else {
            echo "The budget has not been deleted";
        }

            //check to see how many budgets there are already for this category
            $budget1 = new Budget();
            $results = $budget1->find_budgets_start_date_from_x_category_order_by_date($_POST['categoryName']);
            $budgetDates = array();
            foreach ($results as $result) {
                $budgetDates[] = $result->budget_start_date;
            };
            
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
                        $budget2 = new Budget($_POST['categoryName'], null, $olderBudget);
                    if ($budget2->update('budget_end_date',$budgetEndingDate,'ssis') == 'true') {
                            $output = "ok";
                        } else {
                            echo "The budget has not been deleted";
                            exit;
                        }

                    } else {
                        $budgetEndingDate = NULL;
                        $budget3 = new Budget($_POST['categoryName'], null, $olderBudget);
                    if ($budget3->update('budget_end_date',$budgetEndingDate,'ssis') == 'true') {
                            $output = "ok";
                        } else {
                            echo "The budget has not been deleted";
                            exit;
                        }
                    }
                }   
            }
            echo $output;
    }
?>