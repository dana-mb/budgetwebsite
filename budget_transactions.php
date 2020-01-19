

    <?php include("website_header_and_nav_bar.php"); ?>    
    
    <div id="container">
        <div>
            
            <br>
            <?php
                
                $stmt = $link->prepare("select * from `expenses` WHERE `user_id` = ?");
                $stmt->bind_param("i", $user_id);
                
                if ($stmt -> execute()) {

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
                    $result = $stmt -> get_result();
                    while($user = $result->fetch_assoc())
                    {
                    echo "<tr>";
                    echo "<td>" . $user['date'] . "</td>";
                    echo "<td>" . $user['amount'] . "</td>";
                    echo "<td>" . $user['category_name'] . "</td>";
                    echo "<td>" . $user['details'] . "<div class='deleteTransaction'>X</div></td>";
                    echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                }
                $stmt->close();
            ?>
        </div>
    </div>
        
    <?php include("footer.php"); ?>
    
    