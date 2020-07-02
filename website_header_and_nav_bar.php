<?php 

require_once("includes/init.php");
Session::start();

$session = new Session();
$session->session_and_cookie_check();

if(isset($_POST['log-off'])) 
{
    $session = new Session();
    $session->logOut();
}

          

?>

<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="icon" type="image/gif" href="images/wallet.png"> 

        <title>budget website</title>
        <style>
            <?php include("style.css"); ?>
        </style>
    </head>
    <body>
        <div id="topbar-and-nav">
            <div id="topbar">
                <form id="logOff" method="POST"></form>
                <div class="topbar-text" id="main-headline-log-off">
                    <h4 id="main-headline">The Budget Website</h4>
                    <button form="logOff" name="log-off" id="log-Off"><img src="images/logout_door.png" style="width: 30px; height: 30px"></button>
                </div>
                <a href="javascript:void(0);" class="toggleNavMenu" onclick="toggleNavMenu()">
                    <button id="hamburger"></button>
                </a>
                <div id="nav-menu" class="topbar-text">
                    <a href="budget_dashboard.php" id="dashboard" class="nav-button">Dashboard</a>
                    <a href="budget_transactions.php" id="transactions" class="nav-button">Transactions</a>
                    <a href="budget_budget_status.php" id="budget_status" class="nav-button">Budget Status</a>
                    <a href="budget_account.php" id="account" class="nav-button">Account</a>
                </div>  
            </div>
        <div>

        <div id="toastMessage"></div>
        

        
        