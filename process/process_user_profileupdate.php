<?php
    error_reporting(E_ALL);
    session_start();

    require_once('../classes/utilities.php');
    require_once('../classes/User.php');

    if($_POST && isset($_POST["updatebtn"])){

        $firstname = sanitizer($_POST["firstname"]);
        $lastname = sanitizer($_POST["lastname"]);
        $email = sanitizer($_POST["email"]);
        $team_id = sanitizer($_POST["team_id"]);
        $job_title_id = sanitizer($_POST["job_title_id"]);
        $role_id = sanitizer($_POST["role_id"]);

        $user_id = $_SESSION['user_online'];

        $update = $user1->update_profile($firstname, $lastname, $email, $team_id, $job_title_id, $role_id, $user_id );

        if($update){
            $_SESSION['successmessage'] = "Profile updated successfully";
            header("location: ../user_profile.php");
            exit();
        }else{
            $_SESSION['errormessage'] = "Profile update failed...";
            header("location: ../user_profile.php");
            exit();
        }
    }else{
        $_SESSION['errormessage'] = "Invalid access";
        
        header("location: ../login.php");
        exit();
    }
?>