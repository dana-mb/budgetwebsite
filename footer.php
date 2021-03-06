    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>


    <!-- Optional JavaScript -->
    <script type="text/javascript">

      //toggle between the sign-up form & the log-in form
      $(".toggle-forms").click( function() {
        $("#sign-up-form").toggle();
        $("#log-in-form").toggle();
      })


      function verification(e) {
        if("<?php echo $_GET['email']; ?>" == "") {
          if( $("#sign-up-form")[0].checkValidity() ) {
            if( $("#sign-up-inputPassword").val() == $("#sign-up-inputPassword-verify").val() ) {
              e.preventDefault();
            } else {
              e.preventDefault();
              toastMassage("The passwords don't match. please try again.");
              return;
            }
          }
        }

          var email = $('#sign-up-inputEmail').val();
          var password = $('#sign-up-inputPassword').val();
          var getCode = "<?php echo $_GET['code']; ?>";
          var getEmail = "<?php echo $_GET['email']; ?>";
          
          
          $.ajax({
            method: 'POST',
            url: 'ajax/verification.php',
            data: { email:email, password:password, getCode:getCode, getEmail:getEmail},
            dataType: 'html', //send the datatype to the url
            
            success: function(data)
            {
              if (data != null) {
                
                $('h4#index_message').empty().html(data);
                var url= document.location.href;
                window.history.pushState({}, "", url.split("?")[0]); //erase the variables from the url 
              }
              else {
                toastMassage(data);
                console.log(data);
              }
            }
          })
          .fail( function (request, errorType, errorMessage) {
            toastMassage(errorMessage);
            console.log(errorType);
          })
      }

      $('#sign-up').click( verification );
      if ("<?php echo $_GET['email']; ?>" != "") {
        verification();
      }


      function login(e) {
          if( $("#log-in-form")[0].checkValidity() ) {
            e.preventDefault();
          }

          var email = $('#log-in-inputEmail').val();
          var password = $('#log-in-inputPassword').val();
          
          $.ajax({
            method: 'POST',
            url: 'ajax/login.php',
            data: { email:email, password:password },
            dataType: 'html', //send the datatype to the url
            
            success: function(data)
            {
              if (data == 'ok') {
                eval(window.location.href='budget_dashboard.php');
                console.log(data);
              }
              else {
                toastMassage(data);
                $('h4#index_message').empty().html(data);
                console.log();
              }
            }
          })
          .fail( function (request, errorType, errorMessage) {
            toastMassage(errorMessage);
            console.log(errorType);
          })
      }

      $('#log-in').click( login );


      function SendMailforgotPassword(e) {

        if("<?php echo $_GET['email-for-new-password']; ?>" == "") {
          if( $("#forgot-password-form")[0].checkValidity() ) {
              e.preventDefault();
          }
        } else {
          if( $("#insert-new-password-form")[0].checkValidity() ) {
            if( $("#new-password").val() == $("#new-password-verify").val() ) {
              e.preventDefault();
            } else {
              e.preventDefault();
              toastMassage("the passwords don't match. Try again.");
            }
          }
        }

          var email = $('#email-for-forgot-password').val();
          var getCode = "<?php echo $_GET['code-for-new-password']; ?>";
          var getEmail = "<?php echo $_GET['email-for-new-password']; ?>";
          var password = $("#new-password").val();
          
          $.ajax({
            method: 'POST',
            url: 'ajax/send_email_forgot_password.php',
            data: { email:email, getCode:getCode, getEmail:getEmail, password:password },
            dataType: 'html', //send the datatype to the url
            
            success: function(data)
            {
              $(location). attr('href', '#');
              history.pushState({}, null, window.location.href.split('?')[0] );
              
              if (data == 'ok') {
                $('h4#index_message').empty().html("Your password has changed successfully, You may now log in!");
              }
              else if (data == 'verified') {
                $('h4#index_message').empty().html("It looks like you have entered the website after you sent the password reset email from here. <br>Please press on the forgot password button again to reset you password");
              }
              else if (data == 'wrong code') {
                $('h4#index_message').empty().html("It looks like you opened an outdated email. <br>Please open the last email you've got and press on the link to reset your password <br>or press on forgot password again to send a new email to reset your password");
              }
              else {
                $('h4#index_message').empty().html(data);
                console.log();
              }
            }
          })
          .fail( function (request, errorType, errorMessage) {
            toastMassage(errorMessage);
            console.log(errorType);
          })
      }

      $('#submit-email-for-forgot-password').click( SendMailforgotPassword );

      $('#insert-new-password-button').click( SendMailforgotPassword );

      // delete user and all its data from the db
      function deleteUserAccount() {
        if (confirm("Are you sure you want to delete your account?")) 
        {
        $.ajax({
          method: 'POST',
          url: 'ajax/delete_user_account.php',
          data: {},
          dataType: 'html', //send the datatype to the url
          
          success: function(data)
          {
            if (data == "ok") {
              //nothing
            }
            else {
              toastMassage(data);
              console.log();
            }
          }
        })
        .fail( function (request, errorType, errorMessage) {
          toastMassage(errorMessage);
          console.log(errorType);
        })
        }
      }

      $('#delete-user').click( deleteUserAccount );

      
      //when the page is loaded the nav-button that matches the page name will get an active class
      if(location.pathname.split(/(\\|\/)/g).pop().split('.').slice(0, -1).join('.') != 'index'){
        document.addEventListener('DOMContentLoaded', function()
        {
          var url = window.location.pathname;
          var filename = url.substring(url.lastIndexOf('/')+1);
          var url_nav_name = (filename.substr(7)).replace(/\..+$/, '');
          var navbutton = document.getElementById(url_nav_name);
          navbutton.classList.add('active'); 
        })
      }
      

      /* Toggle between showing and hiding the navigation menu links when the user clicks on the hamburger menu / bar icon */
      function toggleNavMenu() {
        var x = document.getElementById("nav-menu");
        $("#hamburger").toggleClass("active");
        
        if (x.style.display === "flex") {
          x.style.display = "none";
        } else {
          x.style.display = "flex";
        }
      }

      // prevent the disappearance of the nav-menu when resizing of the window from width smaller than 640px to larger than that when the hamburger is clicked twice
      $(window).resize(function(){ 
        if ($(window).width() > 640) {
          $("#nav-menu").css("display","flex");
        } else {
          $("#nav-menu").css("display","none");
        }
      })


      // toast message
      function toastMassage(message) {
        $("#toastMessage").html(message);
        var x = document.getElementById("toastMessage");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
      }
      

      function toggleCategory() {
        $("#categories").slideToggle(200);
      }

      $("#category-dropdown").click(toggleCategory); 

      function chooseCategory() {
        $("#category-dropdown").val($(this).val());
        toggleCategory();
      }

      $('input[name="category"]').on('focus', chooseCategory);



      function deleteCategory() {
        var categoryName = $(this).parent().text().slice(0,-1);
        if (confirm("Are you sure you want to delete the category "+categoryName+"?")) 
        {
        $.ajax({
          method: 'POST',
          url: 'ajax/delete_category.php',
          data: {categoryName: categoryName},
          dataType: 'html', //send the datatype to the url
          
          success: function(data)
          {
            if (data == "ok") {
              console.log(categoryName);
              toastMassage("The category "+categoryName+" has been deleted");
              var categoryNameId = categoryName.split(' ').join('-');
              $("#"+categoryNameId).closest("li").remove();
            }
            else {
              toastMassage(data);
              console.log();
            }
          }
        })
        .fail( function (request, errorType, errorMessage) {
          toastMassage(errorMessage);
          console.log(errorType);
        })
        }
      }

      $('.deleteMe').click( deleteCategory );
      
      $('#add_category').click( function (e) {
        $('#add_category_input').toggle();
        $('#add-category-field-empty-message').hide();
        $('#categories').children("button").toggleClass("block none");
      })

      $('#categories').children("button").click( function (e) {
        if( $("#add_category_input")[0].checkValidity() ) {
          e.preventDefault();
          $("#add-category-field-empty-message").hide();
          var newCategoryName = $("#add_category_input").val();
          
          if($("#"+newCategoryName).length > 0) 
          { 
            toastMassage ("There is already a category by that name.");
          } 
          else if (confirm("Are you sure you want to add the category "+newCategoryName+"?")) 
          {        
          $.ajax({
            method: 'POST',
            url: 'ajax/add_category.php',
            data: {newCategoryName: newCategoryName},
            dataType: 'html', //send the datatype to the url
            
            success: function(data)
            {
              if (data == "ok") {
                console.log(newCategoryName);
                toastMassage("The category "+newCategoryName+" has been added successfully");
                $.ajax({
                  method: 'POST',
                  url: 'ajax/get_category_list.php',
                  data: {},
                  dataType: 'html', //send the datatype to the url
                  
                  success: function(data)
                  {
                    console.log(newCategoryName);
                    var newCategoryNameId = newCategoryName.split(' ').join('-');
                    $("#add_category").before(data);
                    $("#add_category").click();
                    $("#add_category_input").val("");
                    $('.deleteMe').click( deleteCategory );
                    $('#'+newCategoryNameId).on('focus', chooseCategory);
                  }
                })
              }
              else {
                toastMassage(data);
                console.log();
              } 
            }
          }) 
          
          .fail( function (request, errorType, errorMessage) {
            toastMassage(errorMessage);
            console.log(errorType);
          })
          }
        }
        else {
          $("#add-category-field-empty-message").show();
        }
      });
      
      // get the value of the select element of the day,month & a year be of today's date
      function expense_date_today() {
        var date = new Date();
        new_expense_date.value = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) + '-' + date.getDate().toString().padStart(2, 0);
        
      };


      //create the data and the colors arrays for the pie chart creation
      var data = [];
      var label='';
      var value='';
      
      for (var i = 0; i < $('#budget-dashboard tbody tr').length; i++)
      {
        data.push({label: $('#budget-dashboard tbody tr:eq("'+i+'") td:eq("0")').html()
                , value: parseInt($('#budget-dashboard tbody tr:eq("'+i+'") td:eq("1")').text(),10) });
        
      }
      
      var colors = [ '#2E8B57', '#66CDAA', '#4682B4', '#BEBEB1', '#CD853F', '#3CB371', '#48D1CC', '#B0C4DE', '#8FBC8B', '#41413C' ];
      // var colors = [ '#FF6969', '#32CD32', '#6969FF', '#F08080', '#4682B4', '#9ACD32', '#40E0D0', '#FFAFAF', '#F0E68C', '#D2B48C' ];
      // var colors = [ '#FF8000', '#B8860B', '#C04000', '#6B8E23', '#CD853F', '#C0C000', '#228B22', '#D2691E' ];

      // create the pie chart only if the dashboard table has any expenses written in the current month
      function checkPieChart() {
        var rows = $('#budget-dashboard tbody tr').length;
        for (var i = 0; i < rows ; i++) {
          if($('#budget-dashboard tbody tr:eq("'+i+'") td:eq("1")').html() == 0) {
          } else {
            drawPieChart(data, colors);
            break;
          }
        }
      }

      checkPieChart();

      
      //creating the pie chart
      function drawPieChart (data, colors) {

        
        
        var calculatePercent = function(value, total) {
          return (value / total * 100).toFixed(0);
        };

        var getTotal = function(data) {
          var sum = 0;
          for(var i=0; i<data.length; i++) {
            sum += data[i].value;
          }
          return sum;
        };

        var calculateStart = function(data, index, total) {
          if(index === 0) {
            return 0;
          }
          return calculateEnd(data, index-1, total);
        };

        var calculateEndAngle = function(data, index, total) {
          var angle = data[index].value / total * 360;
          var inc = ( index === 0 ) ? 0 : calculateEndAngle(data, index-1, total);
          return ( angle + inc );
        };

        var calculateEnd = function(data, index, total) {
          return degreeToRadians(calculateEndAngle(data, index, total));
        };

        var degreeToRadians = function(angle) {
          return angle * Math.PI / 180
        }
        
        

        var canvas = document.getElementById('pie');
        if(document.getElementById('pie')) {


          var ctx = canvas.getContext('2d');
          var x = canvas.width / 1.35;
              y = canvas.height / 1.35;
          var color,
              startAngle,
              endAngle,
              total = getTotal(data);

          // clear the canvas- in case of using the function in an update using ajax
          ctx.clearRect(0, 0, canvas.width, canvas.height);
          
          for(var i=0; i<data.length; i++) {
            color = colors[i];
            startAngle = calculateStart(data, i, total);
            endAngle = calculateEnd(data, i, total);
            
            ctx.beginPath();
            ctx.fillStyle = color;
            //the center of a part of the pie
            ctx.moveTo(x/2.6, y/1.48);
            //the center of the whole pie
            ctx.arc(x/2.6, y/1.48, y-100, startAngle, endAngle);
            ctx.fill();
            //the legend
            legendVerticalPosition = y + i * 30 - 250;
            legendHorizonalPosition = canvas.width - 215;
            ctx.rect(legendHorizonalPosition, legendVerticalPosition, 12, 12);
            ctx.fill();
            ctx.font = "18px sans-serif";
            //the squere next to the legend text
            ctx.fillText(data[i].label + " - " + data[i].value + " (" + calculatePercent(data[i].value, total) + "%)", legendHorizonalPosition + 20, legendVerticalPosition + 10);
          }
        }
      }


      function overdraft() {
        $('#budget-dashboard tr:contains("-")').css('background-color','rgb(233, 107, 107)');
      };

      overdraft();


      $("#add-new-expense-button").click ( function(e) {
        if($('#new-expense-form')[0].checkValidity()) {
          e.preventDefault();
        var expenseAmount = $("#new-expense-amount").val(); 
        var categoryName = $("#category-dropdown").val();
        var expenseDate = $("#new_expense_date").val();
        var expenseDetails = $("#new-expense-details").val();
        
        // add the new expense to the db, if successful - show a toast message, empty the values in the form, get out from the pop up
        $.ajax({
          method: 'POST',
          url: "ajax/add_new_expense.php",
          data: {expenseAmount: expenseAmount, categoryName:categoryName, expenseDate:expenseDate, expenseDetails:expenseDetails},
          dataType: 'html', //send the datatype to the url
          
          success: function(data)
          {
            if (data == "ok") {
              console.log(expenseAmount);
              toastMassage("The expense on the amount of "+expenseAmount+" has been added successfully");
              $("[form='new-expense-form']").val('');

              $("#categories [type='radio']").prop("checked", false);
              
              $(location). attr('href', '#');

              // get all the data for the dashboard and insert it into the dashboard
              $.ajax({
                  method: 'POST',
                  url: 'ajax/post_dashboard_expenses.php',
                  data: {},
                  dataType: 'html', //send the datatype to the url
                  
                  success: function(data)
                  {
                    if(data != "no") {
                      console.log(data);
                      $("#budget-dashboard > tbody").empty().append(data);
                      }
                      overdraft();

                    // create the data and the colors arrays for the pie chart creation
                    // change the pie chart according to the dashboard table
                    var data = [];
                    var label='';
                    var value='';
                    
                    for (var i = 0; i < $('#budget-dashboard tbody tr').length; i++)
                    {
                      data.push({label: $('#budget-dashboard tbody tr:eq("'+i+'") td:eq("0")').html()
                              , value: parseInt($('#budget-dashboard tbody tr:eq("'+i+'") td:eq("1")').text(),10) });
                      
                    }
                    var colors = [ '#2E8B57', '#66CDAA', '#4682B4', '#BEBEB1', '#CD853F', '#3CB371', '#48D1CC', '#B0C4DE', '#8FBC8B', '#41413C' ];
                    
                    drawPieChart (data, colors);
                  }
                })

            }
            else {
              toastMassage(data);
              console.log(data);
            }
          }
        })
        
        .fail( function (request, errorType, errorMessage) {
          toastMassage(errorMessage);
          console.log(errorType);
        })
      }
      })


      


      function deleteTransaction() {
        var expenseDate = $(this).closest("tr").find("td:nth-child(1)").text();
        var expenseAmount = $(this).closest("tr").find("td:nth-child(2)").text();
        var categoryName = $(this).closest("tr").find("td:nth-child(3)").text();
        
        if (confirm("Are you sure you want to delete the transaction of "+categoryName+" on the amount of "+expenseAmount+"?")) 
        {
        $.ajax({
          method: 'POST',
          url: 'ajax/delete_transaction.php',
          data: {expenseDate: expenseDate, expenseAmount:expenseAmount, categoryName:categoryName},
          dataType: 'html', //send the datatype to the url
          
          success: function(data)
          {
            if (data == "ok") {
              console.log(expenseAmount, expenseDate, categoryName);
              toastMassage("The transaction of "+categoryName+" category has been deleted");
              $("#expenses tr > td:contains('"+expenseDate+"') + td:contains('"+expenseAmount+"') + td:contains('"+categoryName+"')").parent().remove();
            }
            else {
              toastMassage(data);
              console.log();
            }
          }
        })
        .fail( function (request, errorType, errorMessage) {
          toastMassage(errorMessage);
          console.log(errorType);
        })
        }
      }

      $('.deleteTransaction').click( deleteTransaction );
      
      function budget_month_today() {
        var date = new Date();
        $("#budget-insert-month").val(date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0)) ;
      }

      budget_month_today();

       //adding the budget through ajax
      $("#add-budget-button").click ( function(e) {
        if($('#new-budget-form')[0].checkValidity()) {
          e.preventDefault();
        var categoryName = $("#category-dropdown").val();
        var budgetAmount = $("#budget-insert-amount").val();
        var budgetStartingDate = $("#budget-insert-month").val();
        
        $.ajax({
          method: 'POST',
          url: 'ajax/add_new_budget.php',
          data: {categoryName:categoryName, budgetAmount:budgetAmount, budgetStartingDate:budgetStartingDate},
          dataType: 'html', //send the datatype to the url
          
          success: function(data)
          {
            if (data == "ok") {
              console.log(categoryName, budgetAmount, budgetStartingDate);
              toastMassage("The budget of "+categoryName+" category has been added successfully");
              $(location). attr('href', '#');
              $("#pop-up-section input").val('');
              budget_month_today();
              $("#categories [type='radio']").prop("checked", false);
              
                $.ajax({
                  method: 'POST',
                  url: 'ajax/post_budget_list.php',
                  data: {},
                  dataType: 'html', //send the datatype to the url
                  
                  success: function(data)
                  {
                    console.log(data);
                    $("#budget-status > tbody").empty().append(data);
                    $('.deleteBudget').click( deleteBudget );
                  }
                })
              }
            else {
              toastMassage(data);
              console.log(data);
            }
          }
        })
        
        .fail( function (request, errorType, errorMessage) {
          toastMassage(errorMessage);
          console.log(errorType);
        })
      }
      })

      $('#budget-insert-amount').on('paste', function (e) {
        var $this = $(this);
        setTimeout(function () {
          $this.val($this.val().replace(/[^0-9]/g, '')) //remove every character that is not a digit
        }, 5);
      })

      function deleteBudget() {
        var categoryName = $(this).closest("tr").find("td:nth-child(1)").text();
        var budgetStartingDate = $(this).closest("tr").find("td:nth-child(2)").text();
        var budgetAmount = $(this).closest("tr").find("td:nth-child(3)").text();
        
        if (confirm("Are you sure you want to delete the budget of "+categoryName+" on the amount of "+budgetAmount+"?")) 
        {
        $.ajax({
          method: 'POST',
          url: 'ajax/delete_budget.php',
          data: {categoryName: categoryName, budgetStartingDate:budgetStartingDate, budgetAmount:budgetAmount},
          dataType: 'html', //send the datatype to the url
          
          success: function(data)
          {
            if (data == "ok") {
              console.log(categoryName, budgetStartingDate);
              $("#budget-status tr > td:contains('"+categoryName+"') + td:contains('"+budgetStartingDate+"')").parent().remove();
              toastMassage("The budget of "+categoryName+" category has been deleted");
            }
            else {
              toastMassage(data);
              console.log(data);
            }
          }
        })
        .fail( function (request, errorType, errorMessage) {
          toastMassage(errorMessage);
          console.log(errorType);
        })
        }
      }

      $('.deleteBudget').click( deleteBudget );


      function sortTable(tableId, n) {
        // get the table id
        var tableId = tableId.closest('table').id;

        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById(tableId);
        switching = true;
        // Set the sorting direction to ascending:
        dir = "asc";
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
          // Start by saying: no switching is done:
          switching = false;
          rows = table.rows;
          /* Loop through all table rows (except the
          first, which contains table headers): */
          for (i = 1; i < (rows.length - 1); i++) {
            // Start by saying there should be no switching:
            shouldSwitch = false;
            /* Get the two elements you want to compare,
            one from current row and one from the next: */
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /* Check if the two rows should switch place,
            based on the direction, asc or desc: */
            if (dir == "asc") {
              if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                // If so, mark as a switch and break the loop:
                shouldSwitch = true;
                break;
              }
            } else if (dir == "desc") {
              if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                // If so, mark as a switch and break the loop:
                shouldSwitch = true;
                break;
              }
            }
          }
          if (shouldSwitch) {
            /* If a switch has been marked, make the switch
            and mark that a switch has been done: */
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            // Each time a switch is done, increase this count by 1:
            switchcount ++;
          } else {
            /* If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again. */
            if (switchcount == 0 && dir == "asc") {
              dir = "desc";
              switching = true;
            }
          }
        }
      }

    </script>
  </body>
</html>