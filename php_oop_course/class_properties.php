<?php

    class cars {

        var $wheel_count = 4; //I don't have to write "var"
        var $door_count = 4;

        function car_detail(){
            return "hi, this car has ". $this->wheel_count ." wheels";
        }
    }

    $bmw = new Cars(); //new instance where the functions/methods will be the same but the values will be different

    $mercedes = new Cars();

    echo $bmw -> wheel_count = 10; //after I've defined the var I dont need to write the $ sign anymore
    echo "<br>";
    echo $mercedes -> wheel_count."<br>";
    echo $mercedes -> car_detail();
    echo $bmw -> car_detail();

?>