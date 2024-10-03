<?php

    error_reporting(E_ALL);
    require_once "../classes/User.php";
    require_once "../classes/utilities.php";

    session_start();

    if($_POST){
        if(isset($_POST["btn_submit"])){
            if($_FILES["userdp"]["error"] == 0){

                // print_r($_POST);
                // print_r($_FILES);
                // exit();
                $firstname = sanitizer($_POST["firstname"]);
                $lastname = sanitizer($_POST["lastname"]);
                $useremail = sanitizer($_POST["useremail"]);
                $team = sanitizer($_POST["team"]);
                $role = sanitizer($_POST["role"]);
                $jobtitle = sanitizer($_POST["jobtitle"]);
                $password = $_POST["password"];
                $confirm_password = $_POST["cpassword"];

                if(empty($firstname) || empty($lastname) || empty($useremail)|| empty( $team)|| empty($role)|| empty($jobtitle)|| empty($password) || empty($confirm_password)){
                    $_SESSION['error_message']="All fields required...";
                    header('location:../register.php');
                    exit();
                }

                $userdp = $_FILES["userdp"];
                $rsp = $user1->create_account($firstname, $lastname, $useremail, $password, $confirm_password, $userdp, $team, $role, $jobtitle);

                if($rsp){
                    $_SESSION['success_message'] = "Account created successfully. Login with your credentials...";
                    header("location: ../login.php");
                    exit();
                }else{
                    $_SESSION['error_message'] = "Something went wrong!!!";
                    header("location: ../register.php");
                    exit();
                }
            }else{
                $_SESSION['error_message'] = "Please uploade an image!!!";
                header("location: ../register.php");
                exit();

            }
        }else{
            $_SESSION['error_message'] = "You must be registered before assessing this page!!!";
            header("location: ../register.php");
            exit();
    }
}
?>