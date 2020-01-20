<!DOCTYPE html>
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
      margin: 0;
    }

    #sign-up-form {
      display: none;
    }

    #logOff {
      float: right;
      font-weight: bold;
      width: 100px;
    }

    #topbar {
      background-color:rgba(128, 128, 128, 0.514);
      overflow: hidden;
    }

    #main-headline {
      color: aliceblue;
      margin-left: 10px;
    }
    
    #container {
      max-width: 1300px;
      margin: 30px 0px;
      position: relative;
      left: 0px;
    }

    #dashboard-container {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-around;
    }

    #container > div {
      margin: 0 10px;
    }

    #expense-button {
      width: 140px;
      height: 50px;
      font-size: large;
      font-weight: bold;
      z-index: 60;
      position: relative;
    }

    .img-arrow-down {
      height: 40px;
      position: relative;
      left: 50px;
      top: 55px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: 0.5s ease-in;
    }

    .img-arrow-down-transform {
      transform: translate(0px,25px);
    }

    #new-expense-section {
      display: none;
    }

    #new-expense-section > ul > li {
      margin-bottom: 10px;
    }
    
    #new-expense-section > ul > li > input {
      margin-left: 20px;
      width: 140px;
      text-align: center;
    } 
    
    #new-expense-section input {
      border-style: none none inset none;
    }

    #new-expense-section input:focus {
      outline-style: none;
      border-color: rgba(0, 0, 255, 0.596);
    }

    #categories {
      /*margin-top: 1rem;*/
      margin-left: 70px;
      padding: 0px;
      /*padding-inline-start: 10px;*/
      display: none;
      width: fit-content;
      border: rgba(128, 128, 128, 0.13);
      border-style: inset;
      margin-top: 5px !important;
      
    }

    #categories > li{
      min-width: max-content;
      padding: 0px;
      display: block;
      list-style: none;
      border-bottom-style: inset;
      margin: 0px;
    }

    #categories > li:hover {
      background-color: antiquewhite;
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

    #pie {
      width: 400px;
      height: 244px;
    }

    #expenses {
      font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
      overflow-x:auto
    }

    #expenses td, #customers th {
      border: 1px solid #ddd;
      padding: 6px;
    }

    #expenses tr:nth-child(even){background-color: #f2f2f2;}

    #expenses tr:hover {background-color: #ddd;}

    #expenses th {
      padding-top: 10px;
      padding-bottom: 10px;
      text-align: left;
      background-color: rgb(34, 168, 155);
      color: white;
    }

    /* -------mostly on cellphones--------*/
    @media (max-width: 640px) {

      #topbar {
        overflow: hidden;
        position: relative;
      }

      #hamburger {
        background-image: url("pictures/hamburger4.png") ;
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

      
      

      /*only when there is a hover option, not on touch screens, for example */
      @media not all and (pointer: coarse) {
      
        #hamburger:hover {
          background-image: url("pictures/hamburger5.png") ;
        }
  
      }

      #hamburger.active {
        background-image: url("pictures/hamburger5.png") ;
      }



      #nav-menu {
        margin-top: 20px;
        display: none;
        flex-direction: column;
      }  

      .nav-button {
        float: left;
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
      }
      
      .nav-button:hover {
        background-color: rgba(46, 45, 45, 0.404);
        text-decoration: none;
        font-weight: bold;
        color: white;
      }

      .active {
        background-color: rgba(46, 45, 45, 0.404);
      }
    }
    
/* display only on computers*/
    @media (min-width: 641px) {


      .topbar-text {
        max-width: 1300px;
        margin: 0 auto;
        left: 10px;
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
        margin: 50px 0% 5vh 0vw;
        padding: 1.5vh 4.5vw 4.5vh 4.4vw;
        border: thin grey inset;
        background-color: gray;
        color: white;
      }

      .nav-button:hover {
        background-color: darkgray;
        text-decoration: none;
        color: white;
      }

      .active{
        padding-bottom: 4vh;
        border-bottom: inset white thick;
        background-color: darkgray;
      }
    }


    </style>
</head>
