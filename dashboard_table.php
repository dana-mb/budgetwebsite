<?php

    include("check_user_id.php");
    include("link.php");

    $stmt = $link->prepare("SELECT s.category_name, e.monthly_expenses, s.expenses, s.budget_money-s.expenses 'balance'
                            FROM 
                                                
                                (SELECT category_name, SUM(amount) 'monthly_expenses'
                                FROM expenses
                                WHERE `user_id` = ? AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())
                                GROUP BY category_name) e 
                                                
                                right join 
                    
                                (SELECT c.`category_name`, SUM(e.expensesSum) AS 'expenses', SUM(e.budget_money)  AS 'budget_money'
                                FROM `categories` c right JOIN 

                                    (SELECT b.budget_start_date, b.category_name , SUM(e.amount) 'expensesSum', 
                                    b.amount * (TIMESTAMPDIFF(MONTH, b.`budget_start_date`, COALESCE( DATE_ADD(b.`budget_end_date`, INTERVAL 1 DAY) ,NOW() ))+1)  'budget_money'
                                    FROM budgets b LEFT JOIN expenses e
                                    ON b.category_name = e.category_name
                                    AND b.`user_id` = e.`user_id`
                                    AND e.`date` BETWEEN b.`budget_start_date` AND COALESCE(b.`budget_end_date`,NOW())
                                    WHERE b.`user_id` = ? 
                                    GROUP BY b.budget_start_date, e.category_name) e

                                ON c.`category_name` = e.`category_name` 
                                GROUP BY c.`category_name`) s
                                                
                            ON e.category_name = s.category_name
                            GROUP BY s.category_name");

    $stmt->bind_param("ii", $user_id,$user_id);

    if ($stmt -> execute()) {

        echo "<table id='budget-dashboard' border='1'>
        <thead>
        <tr>
        <th>Category Name</th>
        <th>Monthly Expenses</th>
        <th>Expenses</th>
        <th>Balance</th>
        </tr>
        </thead>
        <tbody>";

        $result = $stmt -> get_result();
        while($user = $result->fetch_assoc())
        {
            echo "<tr>";
            echo "<td>" . $user['category_name'] . "</td>";
            echo "<td>" . $user['monthly_expenses'] . "</td>";
            echo "<td>" . $user['expenses'] . "</td>";
            echo "<td>" . $user['balance'] . "</td>";
            echo "</tr>";
        }
                        
        echo "</tbody>";
        echo "</table>";
        $stmt->close();
        exit;
    }
?>