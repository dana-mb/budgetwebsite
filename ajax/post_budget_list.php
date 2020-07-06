<?php
        include("../includes/init.php");
        Session::start(); 
    
        $budgets = new Budget();
        $budgets = $budgets->find_user_budgets();
                                
        if ($budgets != null) {

            foreach($budgets as $budget) :
            {
                echo "<tr>";
                echo "<td>" . $budget->category_name . "</td>";
                echo "<td>" .  DateTime::createFromFormat('Y-m-d', $budget->budget_start_date)->format('m-Y') . "</td>";
                echo "<td><span>" . $budget->amount . "</span><div class='deleteBudget'></div></td>";
                echo "</tr>";
            }
            endforeach;
        } else {
            echo "The list can't be reloaded";
        }

?>