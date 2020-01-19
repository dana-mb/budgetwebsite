<?php
    include("check_user_id.php");  
    
        
        $stmt = $link->prepare("SELECT * FROM `budgets` WHERE `user_id` = ? ORDER BY `category_name`, `budget_start_date`");
        $stmt->bind_param("i", $user_id);
                             

        if ($stmt -> execute()) {


            $result = $stmt -> get_result();
            while($user = $result->fetch_assoc())
            {
                $categoryName = $user['category_name'];
                $categoryNameId = str_replace(' ', '-', $categoryName); 
                echo "<tr>";
                echo "<td>" . $user['category_name'] . "</td>";
                echo "<td>" .  DateTime::createFromFormat('Y-m-d', $user['budget_start_date'])->format('m-Y') . "</td>";
                echo "<td>" . $user['amount'] . "<div class='deleteBudget'>X</div></td>";
                echo "</tr>";
            }
            $stmt->close();
            
        } else {
            echo "The list can't be reloaded";
            $stmt->close();
        }

?>