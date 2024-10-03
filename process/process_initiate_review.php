<?php

    error_reporting(E_ALL);
    session_start();
    require_once "../classes/Task.php";
    require_once "../classes/Subtask.php";

    if($_POST && isset($_POST["task_id"])){
        $team_lead_id = $_SESSION["user_teamlead_id"];
        $task_id = $_POST["task_id"];
        $task_status = $_POST["task_status"];
        $task_section = $_POST["task_section"];
        $task_review_status = $_POST["task_review_status"];

        if ($task_section === 1){
            echo json_encode(["status" => "error", "message" => "Task has not started"]);
            return false;
        }
        if($task_review_status === "Initiated"){
            echo json_encode(["status" => "error", "message" => "Task approval is alraedy initiated"]);
            return false;
        }

        $subtasks = $Task->fetch_tasksubtask($task_id);

        $allCompleted = true;

        if($subtasks){
            foreach($subtasks as $subtask){
                $subtask_status_id = $subtask['subtask_status_id'];

                if ($subtask_status_id !== 1) {
                    $allCompleted = false;
                    break;
                }
            }
        }

        if ($allCompleted) {
            $task_details = $Task->initiate_task_review($team_lead_id, $task_id);
            echo json_encode(["status" => "success", "message" => "Task review initiated successfully"]);
            return true;
        } else {
            echo json_encode(["status" => "error", "message" => "Please complete all tasks before submitting this task for review"]);
            return false;
        }
    }
?>
