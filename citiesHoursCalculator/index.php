<?php
    
    // // the clocks
    // $locations = array ('America/Los_Angeles'=>'a','America/Detroit'=>'b','Europe/Moscow'=>'c','Asia/Jerusalem'=>'d');
    // file_put_contents("locationsForTimes.json",json_encode($locations));
   
    // $locationsAndUtc = json_decode(file_get_contents('locationsForTimes.json'), true);
    // $newLocationsAndUtc = [];

    // foreach($locationsAndUtc as $location=>$utcOffset) {
    //     $url = "http://worldtimeapi.org/api/timezone/".$location;
    //     $data = json_decode(file_get_contents($url), true);
    //     $utc_Offset = $data['utc_offset'];
    //     $newLocationsAndUtc[$location] = $utc_Offset;
        
    // }

    // file_put_contents("locationsForTimes.json",json_encode($newLocationsAndUtc));
    
    // // the clocks for time comparison

    // $locations = array ('America/Los_Angeles'=>'a','America/Detroit'=>'b','Europe/Moscow'=>'c','Asia/Jerusalem'=>'d');
    // file_put_contents("locationsForTimeComparison.json",json_encode($locations));
   
    // $locationsAndUtc = json_decode(file_get_contents('locationsForTimeComparison.json'), true);
    // $newLocationsAndUtc = [];

    // foreach($locationsAndUtc as $location=>$utcOffset) {
    //     $url = "http://worldtimeapi.org/api/timezone/".$location;
    //     $data = json_decode(file_get_contents($url), true);
    //     $utc_Offset = $data['utc_offset'];
    //     $newLocationsAndUtc[$location] = $utc_Offset;
        
    // }

    // file_put_contents("locationsForTimeComparison.json",json_encode($newLocationsAndUtc));
    
   
?>

<html>
    <head>
        <title>World Clocks</title>
        <style>
            <?php include("style.css"); ?>
        </style>
    </head>
        
    <body>

        <div id='toastMessage'></div>
    
        <!-- the clocks -->
        <?php
            $locationsAndUtc = json_decode(file_get_contents('locationsForTimes.json'), true);
            echo "<div id='worldClocks' class='flex-container'>";
            foreach($locationsAndUtc as $location=>$utcOffset) {
                $location_city = substr($location, strpos($location, "/") + 1);
                echo "<div><span class='clock' data-timezone='".$location."'></span><div id='".$location_city."-clock' class='clocks'><br>".$location_city."<img src='images/trash-bin.png' class='delete-clock-location'></div></div>";
            };
            echo "</div>";
        ?>

        <a id="pop-up-button" href="#overlay">New Clock</a>

        <div id="overlay" class="overlay">
            <div id="pop-up-section">
                <h4>Choose your new clock</h4>
                <a class="close" href="#">&times;</a>
                <br>
                <form class="text-center" id="insert-new-clock-form" autocomplete="off">
                    <div class="form-group">
                        
                        <datalist id="country">   
                            <?php 
                                $url = "http://worldtimeapi.org/api/timezone/";
                                $data = json_decode(file_get_contents($url), true);
                                $continentsAndCountrys = $data;
                                foreach($continentsAndCountrys as $continentAndCountry) {
                                    echo "<option value='$continentAndCountry'>$continentAndCountry</option>";
                                }
                            ?>
                        </datalist>

                        <input id="add-clock-location" type="text" list="country"></input>
                        
                        
                    </div>
                    
                    <br>
                    <div class="form-group">
                        <button type="submit" id="add-clock-location-button">Add</button>
                    </div>
                </form>
          
            </div>
        </div>
        <br><br><br>
        <hr>

        <!-- the clocks for time comparison -->
        <?php
            $locationsAndUtc = json_decode(file_get_contents('locationsForTimeComparison.json'), true);
            echo "<div id='worldClocks-comparison'>";
            foreach($locationsAndUtc as $location=>$utcOffset) {
                $location_city = substr($location, strpos($location, "/") + 1);
                echo "<div id='".$location_city."-clock-comparison' class='clocks-comparison'><span>".$location_city." </span><input type='datetime-local' class='clocksComparison' id='".$location."' data-timezone='".$location."' onchange='timeComparison(this.id, this)'> <img src='images/trash-bin.png' class='delete-clock-comparison-location'></div>";
            };
            echo "</div>";
        ?>

        <a id="pop-up-button" href="#overlay2">New comparison clock</a>

        <div id="overlay2" class="overlay">
            <div id="pop-up-section">
                <h4>Choose your new clock</h4>
                <a class="close" href="#">&times;</a>
                <br>
                <form class="text-center" id="insert-new-clock-comparison-form" autocomplete="off">
                    <div class="form-group">
                        
                        <datalist id="country-comparison">   
                            <?php 
                                $url = "http://worldtimeapi.org/api/timezone/";
                                $data = json_decode(file_get_contents($url), true);
                                $continentsAndCountrys = $data;
                                foreach($continentsAndCountrys as $continentAndCountry) {
                                    echo "<option value='$continentAndCountry'>$continentAndCountry</option>";
                                }
                            ?>
                        </datalist>

                        <input id="add-clock-comparison-location" type="text" list="country-comparison"></input>
                        
                    </div>
                    
                    <br>
                    <div class="form-group">
                        <button type="submit" id="add-clock-comparison-location-button">Add</button>
                    </div>
                </form>
          
            </div>
        </div>
        
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        
        <script type="text/javascript">
           <?php include("footer.js"); ?>
        </script>
    </body>
</html>
