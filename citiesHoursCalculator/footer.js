    const clocks = document.getElementsByClassName("clock");

    function updateClocks() {
        for (let clock of clocks) {
            let timezone = clock.dataset.timezone;
            let time = new Date().toLocaleTimeString('en-GB', {
                hour: '2-digit',
                minute:'2-digit',
                timeZone: timezone
                });
            clock.textContent = time;
        }
    }

    // Update every minute:
    setInterval(updateClocks, 60000);
    updateClocks();


    // toast message
    function toastMassage(message) {
        $("#toastMessage").html(message);
        var x = document.getElementById("toastMessage");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }


    function deleteClockLocation() {
        var locationToDelete = $(this).parent().text();

        $.ajax({
            method: 'POST',
            url: 'ajax/save_to_locations_for_times.php',
            data: {locationToDelete:locationToDelete},
            dataType: 'html', //send the datatype to the url
            
            success: function(data)
            {
                if (data == "ok") {
                    locationToDelete.replace(/\.[^.]+$/, '');
                    $("#"+locationToDelete+"-clock").parent().remove();
                    console.log(locationToDelete);
                    toastMassage("The clock for "+locationToDelete+" has been deleted");
                }
                else {
                    toastMassage(data);
                    console.log(data);
                }
            }
        })
        .fail( function (request, errorType, errorMessage) {
        console.log(errorType);
        })
    }
    
    $('.delete-clock-location').click( deleteClockLocation );


    function addClockLocation(e) {
        e.preventDefault();
        var locationToAdd = $('#add-clock-location').val();
        var option = $("#country").find("option[value='" + locationToAdd + "']").text();
        if (option == locationToAdd) {        
            
            $.ajax({
                method: 'POST',
                url: 'ajax/save_to_locations_for_times.php',
                data: {locationToAdd:locationToAdd},
                dataType: 'html', //send the datatype to the url
                
                success: function(data)
                {
                    if (data == "ok") {
                        var sep = '/';
                        city = locationToAdd.split(sep).pop();
                        $(location).attr('href', '#');
                        $("#add-clock-location").val('');
                        toastMassage("The clock for "+city+" has been added");
                        $('#worldClocks').append( "<div><span class='clock' data-timezone='"+locationToAdd+"'></span><div id='"+city+"-clock' class='clocks'><br>"+city+"<img src='images/trash-bin.png' class='delete-clock-location'></div></div>");
                        updateClocks();
                        $('.delete-clock-location').click( deleteClockLocation );
                    }
                    else {
                        toastMassage(data);
                        console.log(data);
                    }
                }
            })
            .fail( function (request, errorType, errorMessage) {
            console.log(errorType);
            })
        } else {
            alert("This location is not from the list. Please choose a location from the list");
            $("#add-clock-location").val('');
        }
    }
    
    $('#add-clock-location-button').click( addClockLocation );


    function timeComparison(id, dateAndTime) {

        mainTimezone = dateAndTime.dataset.timezone;
        const pickedDateTime = dateAndTime.value;
        $('.clocksComparison').removeClass("active");
        var element = document.getElementById(id);
        element.classList.add("active");

        var mainLocation = id;
        
        $('.clocksComparison').not(".active").each(function(){
            
            timezone = this.dataset.timezone;

            // The current time of the picked location
            var pickedLocationCurrentTime = new Date(new Date().toLocaleString('en-us', {
                timeZone: mainTimezone
            }));

            // The future time of the picked location pass to new Date d
            // var pickedDateTime = 
            var DateTime = pickedDateTime.split("T");  // 2020-09-25T21:42
            var pickedDate = DateTime[0];
            var pickedTime = DateTime[1];
            var pickedDate = pickedDate.split("-");
            var y = parseInt(pickedDate[0]);
            var m = parseInt(pickedDate[1]-1); // months count starts with 0
            var day = parseInt(pickedDate[2]);
            var pickedTime = pickedTime.split(":");
            var h = parseInt(pickedTime[0]);
            var mi = parseInt(pickedTime[1]);
            
            var d = new Date();
            d.setFullYear(y,m,day);
            d.setHours(h,mi, 0);

            pickedLocationFutureTime = d;

            // The time diff of the picked location
            var pickedLocationTimediff = pickedLocationFutureTime.getTime() - pickedLocationCurrentTime.getTime();

            // The current time of one of the other locations
            var otherLocation = new Date(new Date().toLocaleString('en-us', {
                timeZone: timezone
                }));
            
            // The current time in one of the other location plus the time diff from the picked location
            otherLocationTime = new Date(otherLocation.getTime() + pickedLocationTimediff);
            var t = otherLocationTime;
            var id = (this.id);
            var timeString = t.getFullYear()+"-"+("0" + t.getMonth()).slice(-2)+"-"+("0" + t.getDate()).slice(-2)+"T"+("0" + t.getHours()).slice(-2)+":"+("0" + t.getMinutes()).slice(-2); // yyyy-MM-ddThh:mm;
            document.getElementById(id).value = timeString;
            
        });

    }


    function deleteClockComparisonLocation() {
        var locationToDelete = $(this).closest("div").text().slice(0,-2);
        // alert(locationToDelete);
        $.ajax({
            method: 'POST',
            url: 'ajax/save_to_locations_for_time_comparison.php',
            data: {locationToDelete:locationToDelete},
            dataType: 'html', //send the datatype to the url
            
            success: function(data)
            {
                if (data == "ok") {
                locationToDelete.replace(/\.[^.]+$/, '');
                console.log(locationToDelete);
                
                $("#"+locationToDelete+"-clock-comparison").remove();
                toastMassage("The clock comparison for "+locationToDelete+" has been deleted");
                
                }
                else {
                toastMassage(data);
                console.log(data);
                }
            }
        })
        .fail( function (request, errorType, errorMessage) {
        console.log(errorType);
        })
    }
    
    $('.delete-clock-comparison-location').click( deleteClockComparisonLocation );



    function addClockComparisonLocation(e) {
        e.preventDefault();
        var locationToAdd = $('#add-clock-comparison-location').val();
        var option = $("#country-comparison").find("option[value='" + locationToAdd + "']").text();
        if (option == locationToAdd) {

            $.ajax({
                method: 'POST',
                url: 'ajax/save_to_locations_for_time_comparison.php',
                data: {locationToAdd:locationToAdd},
                dataType: 'html', //send the datatype to the url
                
                success: function(data)
                {
                    if (data == "ok") {
                        var sep = '/';
                        city = locationToAdd.split(sep).pop();
                        console.log(city);
                        
                        $(location).attr('href', '#');
                        $("#add-clock-comparison-location").val('');
                        toastMassage("The clock for "+city+" has been added");           
                        $('#worldClocks-comparison').append( "<div id='"+city+"-clock-comparison' class='clocks-comparison'><span>"+city+" </span><input type='datetime-local' class='clocksComparison' id='"+locationToAdd+"' data-timezone='"+locationToAdd+"' onchange='timeComparison(this.id, this)'> <img src='images/trash-bin.png' class='delete-clock-comparison-location'></div>");
                        $('.delete-clock-comparison-location').click( deleteClockComparisonLocation );
                    }
                    else {
                        toastMassage(data);
                        console.log(data);
                    }
                }
            })
            .fail( function (request, errorType, errorMessage) {
            console.log(errorType);
            })
        } else {
            alert("This location is not from the list. Please choose a location from the list");
            $("#add-clock-comparison-location").val('');
        }
    }
    
    $('#add-clock-comparison-location-button').click( addClockComparisonLocation );

