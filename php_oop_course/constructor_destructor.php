<?php

    class cars {

        public $wheel_count = 4;
        static $door_count = 4;

        function __construct(){ 
            //this method will always happen even if we are not echoing it
            //echo $this->wheel_count;
            echo self::$door_count++;
        }

        function __destruct(){ 
            //this method will always happen even if we are not echoing it
            //echo $this->wheel_count;
            echo self::$door_count--;
        }

        // function details(){ 
        //     echo $this->wheel_count;
        // }


    }

    $bmw = new Cars(); // 4&4
    $mercedes = new Cars(); // 4&5
    $toyota = new Cars(); // 4&6
    //echo $bmw->car_detail(); we dont need to echo the construct method
    // echo $bmw->details();



?>