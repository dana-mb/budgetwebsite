<?php 
    $url = "http://worldtimeapi.org/api/timezone/".$_POST['location'];
    $data = json_decode(file_get_contents($url), true);
    $datetime = $data['datetime'];
    $time = substr($datetime, strpos($datetime, "T")+1, -13);
    echo $time;
    
?>