<?php
    include("../includes/init.php");
    Session::start(); 

    $dashboard_expenses = new Dashboard();
    $dashboard_expenses = $dashboard_expenses->expenses_status_dashboard();
                    
    if ($dashboard_expenses != null) {

        foreach($dashboard_expenses as $dashboard_expense) :
        
        {
                echo "<tr>";
                echo "<td>" . $dashboard_expense->category_name . "</td>";
                echo "<td>" . $dashboard_expense->monthly_expenses . "</td>";
                echo "<td>" . $dashboard_expense->expenses . "</td>";
                echo "<td>" . $dashboard_expense->balance . "</td>";
                echo "</tr>";
                
        }

        endforeach;

    } else {
        echo "no";
    }

?>