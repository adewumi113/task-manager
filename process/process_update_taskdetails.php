<?php

error_reporting(E_ALL);
session_start();
require_once "../classes/Task.php";
require_once "../classes/Subtask.php";

if ($_POST && isset($_POST['update_task_btn'])) {
    // Get data from the form
    $taskID = $_POST["task_id"];
    $taskName = $_POST["task_name"];
    $dueDate = $_POST["task_due_date"];
    $section = $_POST["task_section"];
    $startDate = $_POST["task_start_date"];
    $description = $_POST["task_description"];
    $userid = $_SESSION['user_online'];
    $today = new DateTime();
    $dueDateTime = new DateTime($dueDate);
    if($section == 2){
        $status_id = 2;
    }else if($section == 3){
        $status_id = 3;
    }else if($dueDateTime < $today){
        $status_id = 4;
    }else{
        $status_id = 1;
    }

    // Check if there are attached files
    
    if (isset($_FILES['attached_files'])) {
        $files = $_FILES['attached_files'];

        // Check if all error codes are zero
        $allErrorZero = true;
        foreach ($files['error'] as $error) {
            if ($error != 0) {
                $allErrorZero = false;
                break;
            }
        }

        if ($allErrorZero) {
            $uploadattachments = $Task->upload_task_attachments($taskID, $files, $userid);
            if($uploadattachments){
                echo "Attachment upload successfully!";
            } else {
                // Failed attachment upload
                echo "Attachment upload failed!";
            }
        } 
    } 

    // Update the task in the database with the uploaded file information
    $result = $Task->update_task($taskName, $description, $startDate, $dueDate, $status_id, $section, $taskID);

    if ($result) {
        echo json_encode(["status" => "success", "message" => "Task updated successfully!"]);
    } else {
        echo json_encode(["status" => "success", "message" => "Error updating task!"]);
    }
    
} else {
    // Handle invalid request method
    echo "Invalid request method!";
}

?>
