<?php

    error_reporting(E_ALL);
    session_start();
    require_once "../classes/Task.php";

    if($_POST && isset($_POST["task_id"])){
        $task_status_id = 2;
        $task_section_id = 2;
        $task_review_status = "Reviewed";
        $task_approval_status = "Returned";
        $task_id = $_POST["task_id"];

        $return_task = $Task->return_task($task_status_id, $task_section_id, $task_review_status, $task_approval_status, $task_id);
    
        if($return_task){
            //fetch updated task review and approval status
            $task = $Task->fetch_task($task_id);

            if($task){
                $review_status = $task[0]['task_review_status'];
                $approval_status = $task[0]['task_approval_status'];
                $section = $task[0]['task_section_id'];
                $status = $task[0]['task_status_name'];

                echo json_encode(["status"=>"success", "message" => "Task returned successfully", "review_status" => $review_status, "approval_status" => $approval_status, "task_section" => $section, "task_status" => $status]);
            }else{
                echo json_encode(["status" => "error", "message" => "Something went wrong"]);
            }
        }
    }
?>
