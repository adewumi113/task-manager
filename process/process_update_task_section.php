<?php

error_reporting(E_ALL);
session_start();
require_once "../classes/Task.php";

    if ($_POST && isset($_POST['new_section'])) {
        // Get data from the form
        $taskID = $_POST["task_id"];
        $section = $_POST["new_section"];
        $userid = $_SESSION['user_online'];
        if($section == 'backlog'){
            $section_id = 1;
            $status_id = 1;
        }else if($section == 'in_progress'){
            $section_id = 2;
            $status_id = 2;
        }else if($section == 'completed'){
            $section_id = 3;
            $status_id = 3;
        }else if($dueDateTime < $today){
            $status_id = 4;
        }

        // Update the task section in the database
        $result = $Task->update_task_section( $status_id, $section_id, $taskID);

        if ($result) {
            echo "Task updated successfully!";
        } else {
        
            echo "Error updating task!";
        }
        
    } else {
        echo "Invalid request method!";
    }

?>
