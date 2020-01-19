<?php

    class cars {
        function gretting(){
            echo "hi, this is gretting function activated";
        }
    }

    $bmw = new Cars(); //new instance where the functions/methods will be the same but the values will be different

    $mercedes = new Cars();

    $bmw -> gretting(); //activate the function with the instance
?>