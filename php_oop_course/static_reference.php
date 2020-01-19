<?php

    class cars {

        static $wheel_count = 4; 

        static function car_detail(){
            return self::$wheel_count;
        }
    }

    class Trucks extends Cars {
        static function display() {
            echo parent::car_detail(); //by parent we can call the parent method or property
        }
    }

    Trucks::display();

?>