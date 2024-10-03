<?php

    if(isset($_SESSION['success_message'])){
    echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
 
    unset($_SESSION['success_message']);
    }

?>