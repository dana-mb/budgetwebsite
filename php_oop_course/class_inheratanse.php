<?php

    class cars {

        var $wheels = 4;

        function gretting(){
            return "hello";
        }
    }

    $bmw = new Cars();

    class Trucks extends Cars {
        var $wheels = 10; //if i dont have anything it takes the val from cars class because it extends it
    }

    $tacoma = new Trucks();
    echo $tacoma -> wheels;

?>