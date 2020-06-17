<?php


require_once("includes/init.php");
Session::start();

$session = new Session();
$session->session_and_cookie_check();

include("header.php");
?>

  
  <body>
    <div id="toastMessage"></div>
    <div class="jumbotron text-center">
      <h1 class="display-4">Creating A Budget</h1>
      <p class="lead">Track and save your money</p>
      <hr class="my-4">
      <h4 id="index_message"></h4>
      
      <div class="container" id="signup-login-box">
      
        <form method="post" class="col-sm-5" id="sign-up-form">
          <br>
          <div class="form-group row">
            <label for="inputEmail" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" name="sign-up-email" id="sign-up-inputEmail" placeholder="email@example.com">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Password:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="sign-up-password" id="sign-up-inputPassword" placeholder="Password" autocomplete="on">
            </div>
          </div>
          <div class="form-group">
            <button type="submit" form="sign-up-form" name="sign-up" id="sign-up" class="btn btn-outline-success">Sign Up</button>
          </div>
          <p><b>Signed up already?</b></p>
          <input type="button" class="toggle-forms" id="showLogInForm" value="Log In Form"></input>
        </form>

        <form method="POST" class="col-sm-5" id="log-in-form">
          <br>
          <div class="form-group row">
            <label for="inputEmail" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" name="log-in-email" id="log-in-inputEmail" placeholder="email@example.com">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Password:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="log-in-password" id="log-in-inputPassword" placeholder="Password" autocomplete="on">
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">              
              <input type="checkbox" id="visigned" class="form-check-input" name="stayLoggedIn" value="1">
              <label class="form-check-label" for="visigned">stay logged in</label>
            </div>        
          </div>
          <div class="form-group">
            <button type="submit" form="log-in-form" name="log-in" id="log-in" class="btn btn-outline-success" >Log In</button>
          </div>

          <p><b>Not signed up yet?</b></p>
          <input type="button" class="toggle-forms" id="showSignUpForm" value="Sign Up Form">
        </form>

      </div>
    </div>
    
    <?php include("footer.php"); ?>
  