<?php 


include("check_sessions&cookies.php");


if(isset($_POST['logOff'])) 
{
    unset($_SESSION['budget_website_session']);
    session_destroy();
    unset($_COOKIE['budget_website_cookie']);
    setcookie('budget_website_cookie', '', time() - 3600, '/');
    header("Location: index.php");
}

?>

<?php include("header.php"); ?>
    <body>
        <div id="topbar">
            <div class="topbar-text">
                <form method="POST">
                    <button name="logOff" id="logOff"><img src="pictures/logout_door.png" style="width: 30px; height: 30px"></button>
                </form>
                <h1 id="main-headline">The Budget Website</h1>
            </div>
            <a href="javascript:void(0);" class="toggleNavMenu" onclick="toggleNavMenu()">
                <button id="hamburger"></button>
            </a>
            <div id="nav-menu" class="topbar-text">
                <a href="budget_dashboard.php" id="dashboard" class="nav-button">Dashboard</a>
                <a href="budget_transactions.php" id="transactions" class="nav-button">Transactions</a>
                <a href="budget_budget_status.php" id="budget_status" class="nav-button">Budget Status</a>
                <a href="#charts" id="charts" class="nav-button">Charts</a>
            </div>  
        </div>

        
        