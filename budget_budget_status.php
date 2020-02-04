<?php include("website_header_and_nav_bar.php"); ?>    
    
    <div id="container">

        <div>
            <h4>Insert your budget for each category:</h4>
            <br>

        <?php
        
            include("ajax/check_user_id.php");
            
            include("link.php");
        
            // Table Scheme for budgets table
            $sql_budgets = "CREATE TABLE IF NOT EXISTS `budgets` (
                `category_name` text NOT NULL,
                `budget_id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `amount` int(11) NOT NULL,
                `budget_start_date` date NOT NULL,
                `budget_end_date` date,
                FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
                PRIMARY KEY (`budget_id`)
                
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

            $link->query($sql_budgets);
            
            $stmt = $link->prepare("SELECT * FROM `budgets` WHERE `user_id` = ? ORDER BY `category_name`, `budget_start_date`");
            $stmt->bind_param("i", $user_id);
                                

            if ($stmt -> execute()) {

                echo "<table id='budget-status' border='1'>
                <thead>
                <tr>
                <th>Category Name</th>
                <th>Starting Month</th>
                <th>Amount</th>
                </tr>
                </thead>
                <tbody>";

                $result = $stmt -> get_result();
                while($user = $result->fetch_assoc())
                {
                    echo "<tr>";
                    echo "<td>" . $user['category_name'] . "</td>";
                    echo "<td>" .  DateTime::createFromFormat('Y-m-d', $user['budget_start_date'])->format('m-Y') . "</td>";
                    echo "<td>" . $user['amount'] . "<div class='deleteBudget'>X</div></td>";
                    echo "</tr>";
                }
                $stmt->close();
                echo "</tbody>";
                
                echo "</table><br>";

                echo "<form id='new-budget-form'>";
                echo "Create a new budget:<br><br>";
                echo "<p>For category: ";
                $stmt = $link->prepare("SELECT * FROM `categories` WHERE user_id = ?");
                $stmt->bind_param("i", $user_id);
                                    
                $stmt -> execute();
                $result = $stmt -> get_result();
                mysqli_data_seek($result, 0);
                echo "<select id='budget-select-category'>";
                echo "<option value=''>--Please choose a category--</option>";
                while ($user = $result->fetch_assoc()) 
                {
                    echo("<option value = '" . $user['category_name'] . "'>" . $user['category_name'] . "</option>");
                }
                echo "</select></p>";
                echo "<p>From month: <input id='budget-insert-month' type='month' required></p>"; //type='month' gives a message about deprecation but it's not suppose to be deprecated.
                echo "<p>on the amount of: <input id='budget-insert-amount' type='number' pattern='[0-9]' pattern='[0-9]' 
                onkeypress='return event.charCode >= 48 && event.charCode <= 57' min='10' required></p>";
                echo "<button id='add-budget-button'>Add Budget</button>";
                echo "</form>";
            }
            $stmt->close();

        ?>
        
        </div>
    </div>
        
<?php include("footer.php"); ?>