<?php
    error_reporting(E_ALL);
    session_start();

    require_once("classes/User.php");

    $user1->logout();

    header("location:index.php");

?>