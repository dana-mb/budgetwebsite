<?php

    class cars {

        Private $door_count = 5;

        function get_values(){
            echo $this->door_count;
        }

        function set_values(){
            echo $this->door_count = 10;
        }
    }

    $bmw = new Cars();

    echo $bmw->get_values();
    echo $bmw->set_values();

    //get a property that can only be access inside the class - private
    //that is how we keep var private
?>