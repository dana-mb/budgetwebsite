
    <?php include("website_header_and_nav_bar.php"); ?>
          
          <div id="container">
            <div id="expense-div">
    
              <br>    
              <a id="pop-up-button" href="#overlay" onclick="expense_date_today();">New Expense</a>
              <br><br>
              <div id="overlay" class="overlay">
                <div id="pop-up-section">
                  
                  
                  <h4>Enter your new expense</h4>
                  <a class="close" href="#">&times;</a>
                    
                  <form id="new-expense-form" autocomplete="off"></form>
                      <ul>
                        <li><input form="new-expense-form" type="number" id="new-expense-amount" pattern='[0-9]+' 
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 46" required min="1.00" step="0.01" placeholder="Amount" > </li>
                        <li><input form="new-expense-form" type="text" id="category-dropdown" onkeypress="return false;"placeholder="Category" style="caret-color: 
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

                        <li>
                            <input form="new-expense-form" type='date' id="new_expense_date" required> <button id="todays_date_button" onclick="expense_date_today();">Today</button>
                            
                            
                            
                            
                        </li>
                        <li><input form="new-expense-form" id="new-expense-details" type="text" placeholder="Details"></li>
                    </ul>
                    <button form="new-expense-form" type="submit" id="add-new-expense-button">Add the expence</button>
                    
                    
                </div>
              </div>
            </div>
            <div id="flex-div">
              <div id="pie-div">
                <canvas id="pie" width="600" height="366"></canvas>
              </div>

              <div id="dashboard-table">
                <?php

                  echo "<h5>The budgets for ".date('F Y').":</h5>";

                  $dashboard_expenses = new Dashboard();
                  $dashboard_expenses = $dashboard_expenses->expenses_status_dashboard();
                              
                  echo "<table id='budget-dashboard' border='1'>
                  <thead>
                  <tr>
                  <th onclick='sortTable(this,0)'>Category Name</th>
                  <th onclick='sortTable(this,1)'>Monthly Expenses</th>
                  <th onclick='sortTable(this,2)'>Expenses</th>
                  <th onclick='sortTable(this,3)'>Balance</th>
                  
                  </tr>
                  </thead>
                  <tbody>";

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

                  }
                    
                  echo "</tbody>";
                  echo "</table><br>";

                  

                ?>
              </div>
              
            </div>
          
          </div>

          
          
          <?php include("footer.php");?>