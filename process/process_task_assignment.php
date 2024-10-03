<?php
     error_reporting(E_ALL);
     session_start();
     require_once "../classes/Task.php";
     require_once "../classes/Subtask.php";
 
     if($_POST && isset($_POST["task_id"]) && isset($_POST["assign_to_id"])){
        
         $assigntouserid = $_POST['assign_to_id'];
         $task_id = $_POST["task_id"];
         $resp = $Task->assign_task($task_id, $assigntouserid) ;

        if($resp ){
            $task_assignees = $Task->fetch_task_assignees($task_id);
                return $resp;
            } else {
                return false;
            }
        } else {
            // Handle invalid request method
            echo "Invalid request method!";
        }
?>