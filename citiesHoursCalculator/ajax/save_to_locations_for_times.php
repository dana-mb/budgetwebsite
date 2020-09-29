<?php

    if($_POST['locationToDelete']) {
        //get the array from the json file
        $locationsAndUtc = json_decode(file_get_contents('../locationsForTimes.json'), true);
        $newLocationsAndUtc = [];

        foreach($locationsAndUtc as $location=>$utcOffset) {

            // create a new list without the location we want to delete
            if(!strpos($location, $_POST['locationToDelete'])) {
                $newLocationsAndUtc[$location] = $utcOffset;
            }
        }
        // saving the new array into the json file
        if(file_put_contents("../locationsForTimes.json",json_encode($newLocationsAndUtc))) {
            echo "ok";
        } else {
            echo "could'nt save the new locations";
        }
    }


    if($_POST['locationToAdd']) {
        //get the array from the json file
        $locationsAndUtc = json_decode(file_get_contents('../locationsForTimes.json'), true);
        // $newLocationsAndUtc = [];

        //check if the location is saved already
        if(!array_key_exists($_POST['locationToAdd'], $locationsAndUtc)) {

            // check
            $url = "http://worldtimeapi.org/api/timezone/".$_POST['locationToAdd'];
            $data = json_decode(file_get_contents($url), true);
            $utc_Offset = $data['utc_offset'];
            $locationsAndUtc[$_POST['locationToAdd']] = $utc_Offset;
            
            // saving the new array into the json file
            if(file_put_contents('../locationsForTimes.json',json_encode($locationsAndUtc))) {
                echo "ok";
            } else {
                echo "could'nt save the new locations";
            }

        } else {
            echo 'This clock location is already on the site!';
            exit;
        }
        
        
    }

?>