<?php

    error_reporting(E_ALL);
    session_start();
    require_once "../classes/Subtask.php";

    if($_POST && isset($_POST["task_id"])){

        $taskid = $_POST["task_id"];
        $userid = $_SESSION['user_online'];

        if(!empty($taskid) || !empty($userID)){
            $subtasks = $subtask->fetch_subtask($taskid);
            
            if($subtasks){
                // echo "<pre>";
                // print_r($task);
                // echo "</pre>";
                // die();

                foreach($subtasks as $subtask)
                $str = '<input type="checkbox" id="subtask_status" class="form-check-input me-2" style="width:20px; height:20px; border:1px solid gray">';
                $str .= '<input type="text" class="form-control me-3 subtask_name" placeholder="Input subtask name">';
                $str .= '<input type="date" class="me-3" id="subtask_end_date" style="width:30px;"></i><i class="fa fa-users users-icon me-3"></i><i class="fas fa-comment comment-icon"></i>';
                       
                echo $str;
            }else{
                $_SESSION['error_message'] = "Something went wrong!!!";
                exit();
            }

        }else{
            $_SESSION["error_message"] = "Please select a task...";
            header("location: ../mytasks.php");
            exit();
        }

    }
?>