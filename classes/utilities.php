<?php

    error_reporting(E_ALL);

    #create a function that cleans all evil strings.

    function sanitizer($evil_string){
        $cleaned = strip_tags($evil_string);
        $cleaned = trim($cleaned);
        $cleaned = htmlentities($cleaned);
        return $cleaned;
    }

?>