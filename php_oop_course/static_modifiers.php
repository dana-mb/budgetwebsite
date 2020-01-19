<?php

    class cars {

        //regular property attached to the instent ( you always have to use $variable = new Cars() )
        //static modifier property attached to the class ( is refered to by the class name Cars::$door_count )
        static $wheel_count = 4; 
        static $door_count = 4; 
        

        static function car_detail(){
            // echo $this->wheel_count;
            // echo $this->door_count;
            echo Cars::$wheel_count; //if the method is static use a static var inside
            echo Cars::$door_count;
        }
    }

    $bmw = new Cars();
    echo $bmw->wheel_count;
    echo Cars::$door_count; 
    echo Cars::car_detail(); //to call a static method
    

?>