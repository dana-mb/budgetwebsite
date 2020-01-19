<?php

    class cars {
        function gretting(){

        }
        function gretting2(){

        }
    }

    $the_methods = get_class_methods('cars');

    foreach($the_methods as $method) {
        echo $method."<br>";
    }

?>