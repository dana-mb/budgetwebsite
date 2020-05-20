
    <?php include("website_header_and_nav_bar.php"); ?>
          
          <div id="container">
  
          <?php 

                $email = "dana@localhost";
                $from = "dana@localhost";
                $message = "Your Activation Code is ";
                $to=$email;
                $subject="Activation Code For the Budget Website";
                $from = "danamboyko@gmail.com";
                $body= "Your Activation Code is ";
                $headers = "From:".$from;
                mail($to,$subject,$body,$headers);
                
                // $category = new Category();
                // echo var_dump($categoryName = $category->find_last_inserted_category());
                // echo $categoryName[0]->category_name;
                // `user_id` = ? AND `category_name` = ? AND `budget_start_date` = ?
                // $category_name=null, $amount=null, $budget_start_date=null, $budget_end_date=null

                // echo "update:  ";
                // $budget = new Budget('Vacation', null, '2020-03-01');
                // echo var_dump( $budget->update('budget_end_date','2020-03-31','ssis') );

                // echo "<br>create:  ";
                // $budget2 = new Budget('Vacation', 233, '2020-03-01', '2020-03-31');
                // echo var_dump( $budget2->create() );


                // $abstract_class = new Budget();
                // echo $abstract_class->where_properties('budget_end_date','31-03-31','s');

                // *****update
                    // we dont need the instance we're just calling the method:
                    // $user = User::find_by_id(11);
                    // $user->password = "333";

                    // $user->update();

                // *****mydelete
                    // estantiate the user class:
                    // $user = new User();
                    
                    //     // assigned static strings for the object:
                    //     $user->username = 'example_username';
                    //     $user->password = 'example_password';
                    //     $user->first_name = 'John';
                    //     $user->last_name = 'Doe';

                    // $user->delete();


                // *****delete
                    // estantiate the user class:
                    // $user = User:: find_by_id(3);
                    
                    // $user->delete();

                // include("link.php");
                // $category = "Groceries";
                // $stmt = $link->prepare("SELECT `budget_start_date` FROM `budgets` WHERE `user_id` = ? AND `category_name` = ? ORDER BY `budget_start_date`");
                // $stmt->bind_param("is",$userid,$category);
                // $stmt->execute();
                //  $result = $stmt -> get_result();
                // $budgetDates = array();
                // $output = '';
                // while ($user = mysqli_fetch_assoc($result)) {
                //     $budgetDates[] = $user['budget_start_date'];
                // }
                // var_dump($budgetDates);
                // $stmt->close();

                // echo '<br><br><br>';
                // $budget = new Budget();
                // $results = $budget->find_budgets_start_date_from_x_category_order_by_date("Groceries");
                // var_dump( $results);
                // echo "<br><br>";
                // $budgetDates2 = array();
                //  foreach ($results as $result) {
                //     $budgetDates2[] = $result->budget_start_date;
                // };
                // var_dump($budgetDates2);
                 // $budget = new Budget("Vacation", 188, "2020-02-01", "2020-02-28");
                // $budget->create("siiss");
                
                
                // $session = new Session();
                // echo $session->session_and_cookie_check();
                
                // $user = new User();
                // $user = find_user_info();
                // echo $user->user_computer_token;

                //  $expense = new Expense(12.00, "Groceries", "2020-12-19", "blabla");
                //  print_r($expense->create_new("idsss"));
                
                 // $expense = new Expense();
                // $expense->create([12.00, "Groceries", "2019-12-19", "new"]);
                
                  // echo var_dump(Budget::find_user_budgets_from_x_category("Groceries", "2020-03-01"));
                //   $expense = new Expense(3, $_POST['categoryName'], 
                //   date('Y-m-d', strtotime( $_POST['expenseDate'] )), 
                //   $_POST['expenseDetails']);

                // //   $_POST['expenseAmount'] = 3;
                //   echo $expense->amount;


                // global $database;
                // $database = new Database();
                // Abstract_class::find_by_query("INSERT INTO `expenses` (`user_id`, `amount`,`category_name`, `date`, `details`) VALUES (?,?,?,?,?)", "idsss", 1, 122.00, "Groceries", "2019-12-19", "milk"));
                
                // $sql= "INSERT INTO `expenses` (`user_id`, `amount`,`category_name`, `date`, `details`) VALUES (?,?,?,?,?)";
                // $param_k= "idsss"; 
                // $param= array(1, 122.00, "Groceries", "2019-12-19", "milk");
                // $expense->user_id = self::get_user_id();
                // $expense->amount = $amount;
                // $expense->category_name = $category_name;
                // $expense->date = $date;
                // $expense->details = $details;
                // expense::add_new_expense(12.00, "Groceries", "2019-12-19", "milk");

                //   User::create_table();
                  
                //   $db = new Abstract_class();
                // $db->create_table("CREATE TABLE IF NOT EXISTS `people` (
                //     `ID` int(11) NOT NULL,
                //     `LNAME` varchar(30) NOT NULL,
                //     `FNAME` varchar(30) NOT NULL,
                //     `ADDRESS` varchar(50) NOT NULL
                //   )");

                //   $expense = new Expense;
              
                //   $expense->user_id = '1';
                //   $expense->amount = '200';
                //   $expense->category_name = "Groceries";
                //   $expense->date = '2020-01-17';
                //   $expense->details = "hi";
                  
                //   $expense->delete();
                  
                  // global $user;
                  // $mike = new User();
                  
                  // $mike->print();
                  
                  
                  // echo User::find_user_id();
                  // echo User::$user_id;
                  // echo $t->can;
                  
                  //  $user = new User(); 
                  // echo print_r($user->find_user_info());
                  // user::find_cookie_unique_id_and_token();
                  // echo user::$user_computer_token;

                //   $abstract = new Abstract_class();
            //    echo Abstract_class::call_child_method();
                // $abstract = new Abstract_class();
            // echo Abstract_class::get_user_id();
            //    echo User::name(); 
               //     echo $abstract->userid;

              ?>
  
              <div id="expense-div">
      
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
                                          
                                              <input id='add_category_input' type='text' maxlength='32' onkeypress='return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)' placeholder='New Category' required>
                                              <div id='add-category-field-empty-message'>Please fill out this field</div>
                                              <button class='none'>Add</button>");
                                  
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
  
                  <div id="pie-div">
                        <canvas id="pie" width="400" height="244" ></canvas>
                    </div>
                    <br>

                  <?php
  
                      echo "The budgets for: ".date('F Y');

                    $dashboard_expenses = new Dashboard();
                    $dashboard_expenses = $dashboard_expenses->expenses_status_dashboard();
                                  
                      if ($dashboard_expenses != null) {
  
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
                        
                          echo "</tbody>";
                          
                          echo "</table><br>";
  
                      }
  
                  ?>
                    
              </div>
              
          
          </div>
          
          <?php include("footer.php");?>