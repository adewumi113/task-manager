
<?php
    error_reporting(E_ALL);
    session_start();

    require_once "../classes/utilities.php";
    require_once "../classes/User.php";
    require_once "../classes/Team.php";
    
    if($_POST && isset($_POST["userloginbtn"])){
         //collect the form data and sanitize
         $email = sanitizer($_POST['useremail']);
         $password = $_POST['userpassword'];

        // Retrieve the time zone offset from the client
        $userTimeZone = $_POST['usertimezone'];

        // Use the obtained time zone for date/time operations
        $today = new DateTime("", new DateTimeZone($userTimeZone));
        $_SESSION['today'] = $today;
      
          //validate
        if(empty($email) || empty($password)){
            $_SESSION["error_message"] = "Either email or password is not provided";
            header("location: ../login.php");
            exit();
        }else{
            $user_confirmed = $user1->user_login($email, $password);

            if($user_confirmed){
                $_SESSION['user_team_id'] = $user_confirmed['user_team_id'];
                $_SESSION['user_role_id'] = $user_confirmed['user_role_id'];
                $_SESSION["user_online"] = $user_confirmed["user_id"];
                $user_teamlead_details = $team->fetch_teamlead($_SESSION['user_team_id'], $_SESSION['user_role_id']);
                $_SESSION["user_teamlead_id"] = $user_teamlead_details["user_id"];
                $_SESSION["user_teamlead"] = $user_teamlead_details["user_firstname"] . " " . $user_teamlead_details["user_lastname"];
                $_SESSION["success_message"] = "Login successful";
        
                header("location: ../mytasks.php");
            }else{
                $_SESSION["error_message"] = "Invalid access!!! Wrong details provided";
                header("location: ../login.php");
                }
            } 
    }else{
        $_SESSION["error_message"] = "You have to login to access this page";
        header("location: ../login.php");
        exit();
    }