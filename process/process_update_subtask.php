<?php

error_reporting(E_ALL);
session_start();
require_once "../classes/Task.php";
require_once "../classes/Subtask.php";

    if ($_POST && isset($_POST['subtask_name'])) {
        // Get data from the form
        $taskID = $_POST["task_id"];
        $subtaskName = $_POST["subtask_name"];
        $subtaskDueDate = $_POST["subtask_end_date"];
        $subtaskStatusId = $_POST["subtask_status_id"];
        $subtaskId = $_POST["subtask_id"];
        $userid = $_SESSION['user_online'];

    
        $resp = $subtask->update_subtask($subtaskName, $subtaskDueDate, $subtaskStatusId, $subtaskId);
        if($resp ){
            echo "Subtask updated successfully!";
        } else {
        // Failed attachment upload
            echo "Subtask update failed!";
        }
    } else {
        // Handle invalid request method
        echo "Invalid request method!";
    }

?>
