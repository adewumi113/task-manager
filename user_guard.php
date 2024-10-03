<?php
    if(!isset($_SESSION['user_online'])){
        $_SESSION["userfeedback"] = "You must be logged in in order to access this page";

        header("location: login.php");
        exit();
    }
?>