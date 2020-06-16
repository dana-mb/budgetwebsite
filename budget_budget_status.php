<?php include("website_header_and_nav_bar.php"); ?>    
    
    <div id="container">

        <div>
            <h4>Insert your budget for each category:</h4>
            <br>

            <a id="pop-up-button" href="#overlay">New Budget</a>    
            <div id="overlay" class="overlay">
                <div id="pop-up-section">
                    <form id='new-budget-form'>
                        <h4>Create a new budget:</h4><a class="close" href="#">&times;</a>
                        <br>
                        <p>For category:

                        <?php $categories = new Category();
                        $categories = $categories->find_user_categories();?>

                        <select id='budget-select-category'>
                        <option value=''>--Please choose a category--</option>
                        
                        <?php foreach( $categories as $category ) :
                        {
                            echo("<option value = '" . $category->category_name . "'>" . $category->category_name . "</option>");
                        }
                        endforeach; ?>

                        </select></p>
                        <p>From month: <input id='budget-insert-month' type='month' required></p> <!--type='month' gives a message about deprecation but it's not suppose to be deprecated. -->
                        <p>on the amount of: <input id='budget-insert-amount' type='number' pattern='[0-9]' pattern='[0-9]' 
                        onkeypress='return event.charCode >= 48 && event.charCode <= 57' min='10' required></p>
                        <button id='add-budget-button'>Add Budget</button>
                    </form>
                </div>
            </div>
            <br><br>

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
                    echo "<td><span>" . $budget->amount . "</span><div class='deleteBudget'></div></td>";
                    echo "</tr>";
                }
                endforeach;
                echo "</tbody>";
                
                echo "</table><br>";
            }
            ?>
            

        
        
        </div>
    </div>
        
<?php include("footer.php"); ?>