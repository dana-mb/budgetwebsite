

    <?php include("website_header_and_nav_bar.php"); ?>    
    
    <div id="container">
        <div>
            <?php
                
                $expenses = new Expense();
                $expenses = $expenses->find_user_expenses();
                
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

                if ($expenses != null) {
                    
                    foreach($expenses as $expense) :
                    {
                    echo "<tr>";
                    echo "<td>" . $expense->date . "</td>";
                    echo "<td>" . $expense->amount . "</td>";
                    echo "<td>" . $expense->category_name . "</td>";
                    echo "<td>" . $expense->details . "<div class='deleteTransaction'></div></td>";
                    echo "</tr>";
                    }
                    endforeach;
                }
                
                echo "</tbody>";
                echo "</table>";
                
                
            ?>
            
        </div>
    </div>
        
    <?php include("footer.php"); ?>
    
    