<?php

    class Names {

    }

    $my_classes = get_declared_classes(); //get all the functions that php is declaring automaticly

    foreach ($my_classes as $class) { //in order to see all those functions
        echo $class."<br>";
    }

?>