<?php

    echo __FILE__ . "<br>";

    echo __LINE__ . "<br>";

    echo __DIR__ . "<br>";

    if(file_exists(__DIR__)) {
        echo "<br>This file: ".__DIR__." exist";
    }

    if(is_file(__DIR__)) {
        echo "<br>This: ".__DIR__." is a file";
    } else {
        echo "<br>This: ".__DIR__." is not a file";
    }
    

    if(is_file(__FILE__)) {
        echo "<br>This: ".__FILE__." is a file";
    } else {
        echo "<br>This: ".__FILE__." is not a file";
    }
    

    if(is_dir(__FILE__)) {
        echo "<br>This: ".__FILE__." is a dir";
    } else {
        echo "<br>This: ".__FILE__." is not a dir";
    }

    echo "<br>";

    echo file_exists(__FILE__) ? "yes" : "no";

?>