<?php

    class cars {

        public $wheel_count = 4; //this property can be used anywhere in this script
        Private $door_count = 4; //only for inside a class
        Protected $seat_count = 2; //only inside the class or subclasses

        function car_detail(){
            echo $this->wheel_count;
            echo $this->door_count;
            echo $this->seat_count;
        }
    }

    $bmw = new Cars();
    // echo $bmw->wheel_count; // available - public
    // echo $bmw->door_count; // not available - private
    // echo $bmw->seat_count; // not available - protectected
    echo $bmw->car_detail(); // all available inside a class

?>