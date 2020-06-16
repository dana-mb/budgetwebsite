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

    body {
      margin: 0px;
    }

    #sign-up-form {
      display: none;
    }

    

    #logOff {
      float: right;
      font-weight: bold;
      width: 70px;
    }

    #topbar {
      background-color:rgba(255, 255, 255, 0.514);
      overflow: hidden;
    }

    #main-headline {
      color: grey;
    }

    #toastMessage {
      visibility: hidden;
      min-width: 250px;
      margin-left: -125px;
      background-color: #333;
      color: #fff;
      text-align: center;
      border-radius: 2px;
      padding: 16px;
      position: fixed;
      z-index: 99;
      left: 50%;
      bottom: 30px;
      font-size: 17px;
    }
    
    #toastMessage.show {
      visibility: visible;
      -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
      animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }
    
    @-webkit-keyframes fadein {
      from {bottom: 0; opacity: 0;} 
      to {bottom: 30px; opacity: 1;}
    }
    
    @keyframes fadein {
      from {bottom: 0; opacity: 0;}
      to {bottom: 30px; opacity: 1;}
    }
    
    @-webkit-keyframes fadeout {
      from {bottom: 30px; opacity: 1;} 
      to {bottom: 0; opacity: 0;}
    }
    
    @keyframes fadeout {
      from {bottom: 30px; opacity: 1;}
      to {bottom: 0; opacity: 0;}
    }
    
    #container {
      max-width: 98%;
      margin: 0px auto;
    }

    #dashboard-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
    }

    #container > div {
      margin: 0 auto;
      ;
    }

    #pie-div {
      background-color: rgba(233, 233, 233, 0.589);
      width:vw !important;
      text-align: center;
      min-width: fit-content;
    }

    #pie {
      width: 400px;
      max-height: 244px;
      margin: 10px;
      margin-bottom: -40px;
    }

    /* The same css for all the tables in the website */
    table {
      font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
      overflow-x:auto
    }

     td, #customers th {
      border: 1px solid #ddd;
      padding: 6px;
    }

     tr:nth-child(even){background-color: #f2f2f2;}

     tr:hover {background-color: #ddd;}

     th {
      padding-top: 10px;
      padding-bottom: 10px;
      text-align: left;
      background-color: rgb(34, 168, 155);
      color: white;
    }


    #pop-up-button {
      border-radius: 10px;
      border: double thin rgb(34, 168, 155);
      padding: 8px;
      color: rgb(34, 168, 155);
      text-decoration: none;
      width: 140px;
      height: 50px;
      font-weight: bold;
      position: relative;
      transition: all 0.3s ease-out;
    }

    #pop-up-section button {
      border: double thin rgb(34, 168, 155);
      padding: 6px;
      color: rgb(34, 168, 155);
      text-decoration: none;
      font-size: small;
      font-weight: bold;
      position: relative;
      transition: all 0.3s ease-out;
    }

    #pop-up-button:hover ,#pop-up-section button:hover {
      border-color: white;
      color: white;
      background-color: rgb(34, 168, 155);
    }

    .overlay {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background: rgba(0, 0, 0, 0.75);
      transition: opacity 500ms;
      visibility: hidden;
      opacity: 0;
    }
    .overlay:target {
      visibility: visible;
      opacity: 1;
      z-index: 1;
    }

    #pop-up-section {
      left: 50%;
      top: 50%;
      transform: translate(-50%,-50%);
      min-width: fit-content;
      max-width: 100%;
      border-style: double;
      position: fixed;
      background-color: white;
      transition: all 5s ease-in-out;
      padding: 30px;
    }

    #pop-up-section .close {
      position: absolute;
      top: 5px;
      right: 10px;
      transition: all 200ms;
      font-size: 30px;
      font-weight: bold;
      text-decoration: none;
      color: #333;
    }

    #pop-up-section > ul {
    width: fit-content;
    padding-left: 0;
  }

    #pop-up-section > ul > li {
      margin: 30px auto;
      list-style: none;
      width: 250px;
    }
    
    /*only the inputs of new-expense-form*/
    #pop-up-section > ul > li > input {
      padding-left: 0px;
    } 

    #pop-up-section > ul > li > input:placeholder-shown {
      content: "placeholder";
    }

    #pop-up-section > ul > li > input:placeholder-shown:focus{
      content: "focus";
    }
    
    /*including the input of all the categories*/
    #pop-up-section input {
      border-style: none none inset none;
    }

    #pop-up-section input:focus {
      outline-style: none;
      border-color: rgb(34, 168, 155);
    }

    #categories {
      margin-left: 70px;
      padding: 0px;
      display: none;
      width: fit-content;
      border: none;
      margin-top: 5px !important;
      
    }

    #categories > li{
      min-width: max-content;
      padding: 0px;
      display: block;
      list-style: none;
      border-bottom: inset;
      margin: 0px;

    }

    #categories > li:hover {
      background-color: rgb(188, 238, 233);
    }
    
    #categories > li:focus-within {
      background-color: antiquewhite;
    }

    #categories > li > label:focus {
      background-color: antiquewhite;
    }

    /*the radio box*/
    #categories > li > input {
      text-align: left;
      margin-left: 5px !important;
    }

    #categories > li > label {
      box-sizing: border-box; 
      width: 130px;
      margin: 0;
      padding: 5px  !important;
    }

    .deleteMe {
      float: right;
      text-align: right;
      padding: 5px;
    }

    /*the plus sign*/
    #add_category {
      width: 35px;
      height: 30px;
      margin: auto;
      padding-left: 5px;
      padding-bottom: 5px;
      align-self: center;
    }

    #add_category_input {
      margin: 5px;
      margin-left: 6px;;
      width: auto;
      color: rgba(0, 0, 255, 0.596);
      display: none;
    }

    #add-category-field-empty-message {
      display: none;
      text-align: center;
      outline-style: unset;
      outline-color: red;
      color: red;
      font-size: smaller;
    }

    #categories > button {
      text-align: center;
      margin: 0 auto;
      margin-bottom: 5px;
    }

    .block {
      display: block;
    }

    .none {
      display: none;
    }


    


    /* -------mostly on cellphones--------*/
    @media (max-width: 640px) {

      #topbar {
        overflow: hidden;
        position: relative;
      }



      #hamburger {
        background-image: url("images/hamburger4.png") ;
        background-repeat: no-repeat;
        margin-left: 10px;
        width: 62px;
        height: 60px;
        background-color: transparent;
        border-style: none;
      }

      #hamburger:focus {
      outline: 0;
      }

      #pie {
      max-width: 100%;
    }
      

      /*only when there is a hover option, not on touch screens, for example */
      @media not all and (pointer: coarse) {
      
        #hamburger:hover {
          background-image: url("images/hamburger5.png") ;
        }
  
      }

      #hamburger.active {
        background-image: url("images/hamburger5.png") ;
      }


      #nav-menu {
        margin-top: 20px;
        display: none;
        flex-direction: column;
      }  

      .nav-button {
        float: left;
        display: block;
        color: grey;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
        border-bottom:solid thin rgba(128, 128, 128, 0.575);
      }
      
      .nav-button:hover {
        background-color: rgb(255, 255, 255);
        text-decoration: none;
        color: rgb(55, 192, 178);
      }

      .active {
        background-color: rgb(255, 255, 255);
        color: rgb(55, 192, 178);
      }
    }
    
/* display only on computers*/
    @media (min-width: 641px) {


      .topbar-text {
        max-width: 1300px;
        margin: 0 auto;
      }

      #topbar .toggleNavMenu {
        display: none;
      }

      #nav-menu {
        height: 100px;
        display: flex;
        flex-direction: row;
      }

      .nav-button {
        min-width: 30px;
        height: 35px;
        margin: 60px 0% 5vh 0vw;
        padding: 0.5vh 4.5vw 0vh 4.4vw;
        border-right: thin rgba(128, 128, 128, 0.527) inset;
        background-color: rgb(255, 255, 255);
        color: grey;
      }

      .nav-button:hover {
        background-color: rgb(255, 255, 255);
        color: rgb(55, 192, 178);
      }

      .nav-button:link {
        text-decoration: none;
      }

      .active {
        padding-bottom: 0vh;
        color: rgb(55, 192, 178);
      }



    }


    </style>
</head>
