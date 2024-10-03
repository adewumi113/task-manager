<?php
    error_reporting(E_ALL);
    session_start();
    require_once "../classes/Subtask.php";
    require_once "../classes/utilities.php";

    if ($_POST && isset($_POST["subtask_name"])) {
        print_r($_POST);
        $subtaskName = sanitizer($_POST["subtask_name"]);
        $subtaskEndDate = $_POST["subtask_end_date"]; //
        $taskID = $_POST["task_id"]; 
        $subtaskStatusId = $_POST["subtask_status_id"]; 
        $userid = $_SESSION['user_online'];

        if (!empty($subtaskName) && !empty($subtaskEndDate) && !empty($taskID)) {
            $addsubtask = $subtask->add_subtask($taskID, $subtaskName, $subtaskEndDate, $subtaskStatusId, $userid);

            if ($addsubtask) {
                
                $subtasks = $subtask->fetch_subtask($taskID);
                return $subtasks;

            } else {
                // Send an error response
                $response = array("status" => "failed", "message" => "Something went wrong while adding subtask!!!");
                echo json_encode($response);
            }
        } else {
                 // Send an error response
            $response = array("status" => "failed", "message" => "Please provide all details for the subtask...");
            echo json_encode($response);
            exit();
        }
    }
?>
