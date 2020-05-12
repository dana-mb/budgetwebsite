<?php include("website_header_and_nav_bar.php"); ?>    
    
    <div id="container">

        <div>
            <h4>Insert your budget for each category:</h4>
            <br>

        <?php
        
            $budgets = new Budget();
            $budgets = $budgets->find_user_budgets();
                                
            if ($budgets != null) {

                echo "<table id='budget-status' border='1'>
                <thead>
                <tr>
                <th>Category Name</th>
                <th>Starting Month</th>
                <th>Amount</th>
                </tr>
                </thead>
                <tbody>";

                foreach($budgets as $budget) :
                {
                    echo "<tr>";
                    echo "<td>" . $budget->category_name . "</td>";
                    echo "<td>" .  DateTime::createFromFormat('Y-m-d', $budget->budget_start_date)->format('m-Y') . "</td>";
                    echo "<td>" . $budget->amount . "<div class='deleteBudget'>X</div></td>";
                    echo "</tr>";
                }
                endforeach;
                echo "</tbody>";
                
                echo "</table><br>";
            }
                echo "<form id='new-budget-form'>";
                echo "Create a new budget:<br><br>";
                echo "<p>For category: ";

                $categories = new Category();
                $categories = $categories->find_user_categories();

                echo "<select id='budget-select-category'>";
                echo "<option value=''>--Please choose a category--</option>";
                
                foreach( $categories as $category ) :
                {
                    echo("<option value = '" . $category->category_name . "'>" . $category->category_name . "</option>");
                }
                endforeach;

                echo "</select></p>";
                echo "<p>From month: <input id='budget-insert-month' type='month' required></p>"; //type='month' gives a message about deprecation but it's not suppose to be deprecated.
                echo "<p>on the amount of: <input id='budget-insert-amount' type='number' pattern='[0-9]' pattern='[0-9]' 
                onkeypress='return event.charCode >= 48 && event.charCode <= 57' min='10' required></p>";
                echo "<button id='add-budget-button'>Add Budget</button>";
                echo "</form>";
            

        ?>
        
        </div>
    </div>
        
<?php include("footer.php"); ?>