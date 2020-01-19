
<?php require_once("includes/init.php"); ?>
    <?php include("website_header_and_nav_bar.php"); ?>
          
        <div id="container">

        <?php 
                
                $expense = new Expense;
            
                
                $expense->user_id = '1';
                $expense->amount = '200';
                $expense->category_name = "Groceries";
                $expense->date = '2020-01-17';
                $expense->details = "hi";
                
                $expense->delete();
                
                
            
            
            
            ?>

            <div>
    
                <img class="img-arrow-down" src="images/arrow_down.png">
                <button id="expense-button">New Expense</button>
                <br><br>

                <div id="new-expense-section">
                    
                    <form  id="new-expense-form" autocomplete="off"></form>
                    <ul >
                        <li>Amount: <input form="new-expense-form" type="number" id="new-expense-amount" pattern='[0-9]+' 
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 46" required min="1.00" step="0.01"  > </li>
                        <li>Category:&emsp; <input form="new-expense-form" type="text" id="category-dropdown" onkeypress="return false;"placeholder="select" style="caret-color: 
                            transparent;" required> 
                        <ul id="categories">
                            <?php 
                                include("check_user_id.php");
                                
                                $stmt = $link->prepare("SELECT * FROM `categories` WHERE `user_id` = ?");
                                $stmt->bind_param("i", $user_id);
                                
                                $stmt -> execute();
                                $result = $stmt -> get_result();

                                while($user = $result->fetch_assoc())
                                {   
                                    $categoryName = $user['category_name'];
                                    $categoryNameId = str_replace(' ', '-', $categoryName); 

                                    echo("<li><input type='radio' name='category' id=".$categoryNameId." value='".$categoryName."'><label for=".$categoryNameId.">".$categoryName."</label><div class='deleteMe'>X</div></li>");
                                }

                                echo ("<img id='add_category' class='block' src='images/plus-sign.png'>
                                        
                                            <input id='add_category_input' type='text' maxlength='32' onkeypress='return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)' placeholder='New Category' required>
                                            <div id='add-category-field-empty-message'>Please fill out this field</div>
                                            <button class='none'>Add</button>");
                                $stmt->close();
                            ?>
                            
                        </ul>
                        </li>

                        <li> Date: 
                            <input form="new-expense-form" type='date' id="new_expense_date" required> <button id="todays_date_button">Today</button>
                            
                            
                            
                            
                        </li>
                        <li>Details: <input form="new-expense-form" id="new-expense-details" type="text"></li>
                    </ul>
                    <button form="new-expense-form" type="submit" id="add-new-expense-button">Add the expence</button>
                    
                </div>

                <?php

                    include("check_user_id.php");
                            
                    include("link.php");

                    echo "The budgets for: ".date('F Y');

                    

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
                        $stmt->close();
                        echo "</tbody>";
                        
                        echo "</table><br>";

                    }

                ?>

                <canvas id="pie" width="400" height="244" ></canvas>

            </div>
            
        
        </div>
        
        <?php include("footer.php");?>