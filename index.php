<?php
require_once("includes/init.php");
Session::start();

$session = new Session();
$session->session_and_cookie_check();

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
    <div id="toastMessage"></div>
    
    <div id="overlay" class="overlay">
      <div id="pop-up-section">
        
        <h4>Enter your new password</h4>
        <a class="close" href="#">&times;</a>
          <br>
        <form class="text-center" id="insert-new-password-form">
          <input type='text' style="display: none;" autocomplete="username">
          <div class="form-group">
            <input type='password' id="new-password" placeholder="password" autocomplete="new-password" required>
          </div>
          <div class="form-group">
            <input type='password' id="new-password-verify" placeholder="password verification" autocomplete="new-password" required>
          </div>
          <br>
          <div class="form-group">
            <button type="submit" id="insert-new-password-button">Submit</button>
          </div>
        </form>
          
      </div>
    </div>

    <div class="jumbotron text-center">
      <h1 class="display-4">Creating A Budget</h1>
      <p class="lead">Track and save your money</p>
      <hr class="my-4">
      <h4 id="index_message"></h4>
      
      <div class="container" id="signup-login-box" style="max-width: 300px">

        <ul class="nav nav-pills justify-content-center">
          <li><a class="nav-link active" data-toggle="pill" href="#log-in-form">Log In</a></li>
          <li><a class="nav-link" data-toggle="pill" href="#sign-up-form">Sign Up</a></li>
        </ul>

        <div class="tab-content">
          
          <form method="post" class="tab-pane col-md-12" id="sign-up-form">
            <br>
            <div class="form-group row">
              <input type="email" class="form-control" name="sign-up-email" id="sign-up-inputEmail" placeholder="email@example.com" autocomplete="username">
            </div>
            <div class="form-group row">
              <input type="password" class="form-control" name="sign-up-password" id="sign-up-inputPassword" placeholder="password" autocomplete="new-password">
            </div>
            <div class="form-group row">
              <input type="password" class="form-control" name="sign-up-password-verify" id="sign-up-inputPassword-verify" placeholder="password verification" autocomplete="new-password">
            </div>
            <div class="form-group">
              <button type="submit" form="sign-up-form" name="sign-up" id="sign-up" class="btn btn-outline-success">Sign Up</button>
            </div>
          </form>

          <form method="POST" class="tab-pane active col-md-12" id="log-in-form">
            <br>
            <div class="form-group row">
              <input type="email" class="form-control" name="log-in-email" id="log-in-inputEmail" placeholder="email@example.com" autocomplete="username">
            </div>
            <div class="form-group row">
              <input type="password" class="form-control" name="log-in-password" id="log-in-inputPassword" placeholder="password" autocomplete="current-password">
            </div>
            <div class="form-group">
              <div class="form-check">              
                <input type="checkbox" id="visigned" class="form-check-input" name="stayLoggedIn" value="1">
                <label class="form-check-label" for="visigned">stay logged in</label>
              </div>        
            </div>
            <div class="form-group">
              <button type="submit" form="log-in-form" name="log-in" id="log-in" class="btn btn-outline-success">Log In</button>
            </div>
            <a for="forgot-password-form" class="pointer" type="button" data-toggle="collapse" data-target="#div-email-for-forgot-password" aria-expanded="false" aria-controls="div-email-for-forgot-password">
              Forgot Password?
            </a>
          </form>

          
          <div class="collapse" id="div-email-for-forgot-password">
            <div class="card card-body">
              <form id="forgot-password-form">
                <div class="form-group">
                  <p>Enter your email.<br> If it exist, we will send you an email with a link to reset your password.</p>
                  <input type="email" class="form-control" name="email-for-forgot-password" id="email-for-forgot-password" placeholder="email@example.com" autocomplete="username">
                </div>
                <div class="form-group">
                  <button type="submit" name="submit-email-for-forgot-password" id="submit-email-for-forgot-password" class="btn btn-outline-success">Submit</button>
                </div>           
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>
    
    <?php include("footer.php"); ?>
  