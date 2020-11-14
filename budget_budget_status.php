<?php include("website_header_and_nav_bar.php"); ?>    
    
    <div id="container">

        <div>
            <br>

            <a id="pop-up-button" href="#overlay">New Budget</a>    
            <div id="overlay" class="overlay">
                <div id="pop-up-section">
                    <form id='new-budget-form'></form>
                        <h4>Create a new budget:</h4><a class="close" href="#">&times;</a>
                        <ul>
                        <li><input form='new-budget-form' type="text" id="category-dropdown" onkeypress="return false;"placeholder="Category" style="caret-color: 
                            transparent;" required> 
                            <ul id="categories">
                                <?php 
                                    $category = new Category();
                                    $categories = $category->find_user_categories($userid);
                            
                                    foreach( $categories as $category ) :
                                    {   
                                        $categoryName = $category->category_name;
                                        $categoryNameId = str_replace(' ', '-', $categoryName); 

                                        echo("<li><input type='radio' name='category' id=".$categoryNameId." value='".$categoryName."'><label for=".$categoryNameId.">".$categoryName."</label><div class='deleteMe'>X</div></li>");
                                    }
                                    endforeach;

                                    echo ("<img id='add_category' class='block' src='images/plus-sign.png'>
                                            
                                                <input id='add_category_input' type='text' maxlength='32' onkeypress='return (event.charCode > 64 && event.charCode < 91 && event.charCode = 32) || (event.charCode > 96 && event.charCode < 123)' placeholder='New Category' required>
                                                <div id='add-category-field-empty-message'>Please fill out this field</div>
                                                <button class='none'>Add</button>");
                                    
                                ?>
                                
                            </ul>
                        </li>

                        <li><input form='new-budget-form' id='budget-insert-month' type='month' placeholder='Starting month' required><button id="todays_month_button" onclick="budget_month_today();">From This Month</button></li> <!--type='month' gives a message about deprecation but it's not suppose to be deprecated. -->
                        <li><input form='new-budget-form' id='budget-insert-amount' type='number' pattern='[0-9]' pattern='[0-9]' 
                        onkeypress='return event.charCode >= 48 && event.charCode <= 57' min='10' placeholder='Amount' required></li>
                        </ul>
                        <button type='submit' form='new-budget-form' id='add-budget-button'>Add Budget</button>
                    
                </div>
            </div>
            <br><br>

            <?php
            
                $budgets = new Budget();
                $budgets = $budgets->find_user_budgets();
                
                echo "<table id='budget-status' border='1'>
                <thead>
                <tr>
                <th onclick='sortTable(this,0)'>Category Name</th>
                <th onclick='sortTable(this,1)'>Starting Month</th>
                <th onclick='sortTable(this,2)'>Amount</th>
                </tr>
                </thead>
                <tbody>";

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
                }

                echo "</tbody>";
                
                echo "</table><br>";
                
            ?>
            
        
        </div>
    </div>
        
<?php include("footer.php"); ?>