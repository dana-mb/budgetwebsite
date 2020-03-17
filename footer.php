    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    
    

    <!-- Optional JavaScript -->
    <script type="text/javascript">

     /* $(document)
      .ajaxStart(function ()
      { 
        $.ajax({
          type:"post",
          url:"check_sessions&cookies.php",
          datatype:"html",
          success:function(data)
          {
              //do something with response data
          }
        });
      })*/

      //toggle between the sign-up form & the log-in form
      $(".toggle-forms").click( function() {
        $("#sign-up-form").toggle();
        $("#log-in-form").toggle();
      })
      
      //when the page is loaded the nav-button that matches the page name will get an active class
      document.addEventListener('DOMContentLoaded', function() 
      {
        var url = window.location.pathname;
        //var filename = path.split('/').pop();
        var filename = url.substring(url.lastIndexOf('/')+1);
        var url_nav_name = (filename.substr(7)).replace(/\..+$/, '');
        var navbutton = document.getElementById(url_nav_name);
        navbutton.classList.add('active'); 
      })
      

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

      //prevent the dissapearance of the nav-menu when resizing of the window from width smaller than 640px to larger than that when the hamburger is clicked twice
      $(window).resize(function(){ 
        if ($(window).width() > 640) {
          $("#nav-menu").css("display","flex");
        } else {
          $("#nav-menu").css("display","none");
        }
      })
      
      
      //use the expense button to open a div where the user could insert all the info about the expense 
      function toggleExpenseButton() {  
        $('.img-arrow-down').toggleClass('img-arrow-down-transform');
        $('#new-expense-section').toggle(500);
        expense_date_today();
      };

      $("#expense-button").click(toggleExpenseButton);

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
              alert("The category "+categoryName+" has been deleted");
              var categoryNameId = categoryName.split(' ').join('-');
              $("#"+categoryNameId).closest("li").remove();
            }
            else {
              alert(data);
              console.log();
            }
          }
        })
        .fail( function (request, errorType, errorMessage) {
          alert(errorMessage);
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
            alert ("There is already a category by that name.");
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
                alert("The category "+newCategoryName+" has been added successfully");
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
                alert(data);
                console.log();
              } 
            }
          }) 
          
          .fail( function (request, errorType, errorMessage) {
            alert(errorMessage);
            console.log(errorType);
          })
          }
        }
        else {
          $("#add-category-field-empty-message").show();
        }
      });
      
      //get the value of the select element of the day,month & a year be of today's date
      function expense_date_today() {
        var date = new Date();
        new_expense_date.value = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) + '-' + date.getDate().toString().padStart(2, 0);
        
      };



        var calculatePercent = function(value, total) {
          return (value / total * 100).toFixed(2);
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

      
        var data = [];
        var label='';
        var value='';
        
        if ( $('#budget-dashboard tbody tr:eq("0") td:eq("1")').html() != null &&
              $('#budget-dashboard tbody tr:eq("1") td:eq("1")').html() != null ) {

          for (var i = 0; i < $('#budget-dashboard tbody tr').length; i++)
          {
            data.push({label: $('#budget-dashboard tbody tr:eq("'+i+'") td:eq("0")').html()
                    , value: parseInt($('#budget-dashboard tbody tr:eq("'+i+'") td:eq("1")').text(),10) });
            
          }

        }

        var colors = [ '#39CCCC', '#3D9970', '#001F3F', '#85144B' ];
      
        drawPieChart(data, colors);
      

      // check if canvas element exist...
      // if(document.getElementById('pie')) {
        //creating the pie chart
        function drawPieChart (data, colors) {
          var canvas = document.getElementById('pie');
          if(document.getElementById('pie')) {
            var ctx = canvas.getContext('2d');
            var x = canvas.width / 1.3;
                y = canvas.height / 1.3;
            var color,
                startAngle,
                endAngle,
                total = getTotal(data);
            
            for(var i=0; i<data.length; i++) {
              color = colors[i];
              startAngle = calculateStart(data, i, total);
              endAngle = calculateEnd(data, i, total);
              
              ctx.beginPath();
              ctx.fillStyle = color;
              //the center of a part of the pie
              ctx.moveTo(x/3.4, y/2);
              //the center of the whole pie
              ctx.arc(x/3.4, y/2, y-100, startAngle, endAngle);
              ctx.fill();
              ctx.rect(canvas.width - 200, y - i * 30 - 100, 12, 12);
              ctx.fill();
              ctx.font = "13px sans-serif";
              ctx.fillText(data[i].label + " - " + data[i].value + " (" + calculatePercent(data[i].value, total) + "%)", canvas.width - 200 + 20, y - i * 30 + 10 - 100);
            }
          }
        }
        
      

          
      // }

      //when the user wants todays date he clicks on the button that calls for the function
      // I don't use parentheses for the function because I want to call the function only after the click
      $("#todays_date_button").click( expense_date_today );

      $("#add-new-expense-button").click ( function(e) {
        if($('#new-expense-form')[0].checkValidity()) {
          e.preventDefault();
        var expenseAmount = $("#new-expense-amount").val(); 
        var categoryName = $("#category-dropdown").val();
        var expenseDate = $("#new_expense_date").val();
        var expenseDetails = $("#new-expense-details").val();
        
        $.ajax({
          method: 'POST',
          url: "ajax/add_new_expense.php",
          data: {expenseAmount: expenseAmount, categoryName:categoryName, expenseDate:expenseDate, expenseDetails:expenseDetails},
          dataType: 'html', //send the datatype to the url
          
          success: function(data)
          {
            if (data == "ok") {
              console.log(expenseAmount);
              alert("The expense on the amount of "+expenseAmount+" has been added successfully");
              $("[form='new-expense-form']").val('');
              toggleExpenseButton();
              $("#categories [type='radio']").prop("checked", false);
              // $("#pie").replace().add();
              drawPieChart(data, colors);
            }
            else {
              alert(data);
              console.log(data);
            }
          }
        })
        
        .fail( function (request, errorType, errorMessage) {
          alert(errorMessage);
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
              alert("The transaction of "+categoryName+" category has been deleted");
              $("#expenses tr > td:contains('"+expenseDate+"') + td:contains('"+expenseAmount+"') + td:contains('"+categoryName+"')").parent().remove();
            }
            else {
              alert(data);
              console.log();
            }
          }
        })
        .fail( function (request, errorType, errorMessage) {
          alert(errorMessage);
          console.log(errorType);
        })
        }
      }

      $('.deleteTransaction').click( deleteTransaction );
      
      var date = new Date();
      $(".budget-starting-month").val(date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0)) ;
       
       //adding the budget through ajax
      $("#add-budget-button").click ( function(e) {
        if($('#new-budget-form')[0].checkValidity()) {
          e.preventDefault();
        var categoryName = $("#budget-select-category option:selected").text(); 
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
              alert("The budget of "+categoryName+" category has been added successfully");
              $("#new-budget-form input").val('');
              document.querySelector('#budget-select-category').selectedIndex = 0;
              
                $.ajax({
                  method: 'POST',
                  url: 'ajax/post_budget_list.php',
                  data: {},
                  dataType: 'html', //send the datatype to the url
                  
                  success: function(data)
                  {
                    $("#budget-status > tbody").empty().append(data);
                    $('.deleteBudget').click( deleteBudget );
                  }
                })
              }
            else {
              alert(data);
              console.log(data);
            }
          }
        })
        
        .fail( function (request, errorType, errorMessage) {
          alert(errorMessage);
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
        var budgetAmount = $(this).closest("tr").find("td:nth-child(3)").text().slice(0,-1);
        
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
              alert("The budget of "+categoryName+" category has been deleted");
              $("#budget-status tr > td:contains('"+categoryName+"') + td:contains('"+budgetStartingDate+"')").parent().remove();
            }
            else {
              alert(data);
              console.log();
            }
          }
        })
        .fail( function (request, errorType, errorMessage) {
          alert(errorMessage);
          console.log(errorType);
        })
        }
      }

      $('.deleteBudget').click( deleteBudget );

      

    </script>
  </body>
</html>
