

    <?php include("website_header_and_nav_bar.php"); ?>    
    
    <div id="container">
        <div>
            
            <br>
            <?php
                
                $expenses = Expense::find_user_expenses();
                
                if ($expenses != null) {

                    echo "<table id='expenses' border='1'>
                    <thead>
                    <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Details</th>
                    </tr>
                    </tbody>";
                    echo "<tbody>";
                    
                    foreach($expenses as $expense) :
                    {
                    echo "<tr>";
                    echo "<td>" . $expense->date . "</td>";
                    echo "<td>" . $expense->amount . "</td>";
                    echo "<td>" . $expense->category_name . "</td>";
                    echo "<td>" . $expense->details . "<div class='deleteTransaction'>X</div></td>";
                    echo "</tr>";
                    }
                    endforeach;

                    echo "</tbody>";
                    echo "</table>";
                }
                
            ?>
            
        </div>
    </div>
        
    <?php include("footer.php"); ?>
    
    