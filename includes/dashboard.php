<?php

class Dashboard extends Abstract_class {

    // protected static $table = "expenses";
    protected static $table_fields = array('category_name','monthly_expenses','expenses','balance');
    // protected static $table_param_t = "idsss";
    public $user_id;
    public $category_name;
    public $monthly_expenses;
    public $expenses;
    public $balance;


    public function expenses_status_dashboard() {
            
        $dashboard_array = self::find_by_query("SELECT s.category_name, e.monthly_expenses, s.expenses, s.budget_money-s.expenses 'balance'
                                            FROM 
            
                                                (SELECT category_name, SUM(amount) 'monthly_expenses'
                                                FROM expenses
                                                WHERE `user_id` = ? AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())
                                                GROUP BY category_name) e 
                                                
                                                right join 

                                                (SELECT c.`category_name`, SUM(e.expensesSum) AS 'expenses', SUM(e.budget_money)  AS 'budget_money'
                                                FROM `categories` c right JOIN 

                                                    (SELECT b.budget_start_date, b.category_name , SUM(e.amount) 'expensesSum', 
                                                    b.amount * (TIMESTAMPDIFF(MONTH, b.`budget_start_date`, COALESCE( DATE_ADD(b.`budget_end_date`, INTERVAL 1 DAY) ,NOW() ))+1)  'budget_money'
                                                    FROM budgets b LEFT JOIN expenses e
                                                    ON b.category_name = e.category_name
                                                    AND b.`user_id` = e.`user_id`
                                                    AND e.`date` BETWEEN b.`budget_start_date` AND COALESCE(b.`budget_end_date`,NOW())
                                                    WHERE b.`user_id` = ? 
                                                    GROUP BY b.budget_start_date, e.category_name) e

                                                ON c.`category_name` = e.`category_name` 
                                                GROUP BY c.`category_name`) s
                                                
                                            ON e.category_name = s.category_name
                                            WHERE s.expenses > 0
                                            GROUP BY s.category_name", "ii", [$this->get_user_id(), $this->get_user_id()]);
        
        return $dashboard_array;
    }





}

?>