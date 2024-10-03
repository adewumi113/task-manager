<?php

    error_reporting(E_ALL);
    session_start();
    require_once "../classes/Task.php";

    if($_POST && isset($_POST["task_id"])){
        $comment_text = $_POST['comment_text'];
        $user_id = $_SESSION["user_online"];
        $task_id = $_POST["task_id"];

        $comment = $Task->add_task_comment($task_id, $user_id,$comment_text);
        if($comment){
            echo json_encode(["status" => "success", "message" => "Comment added"]);
            exit();
        } else {
            echo json_encode(["status" => "error", "message" => "Error!!! Comment not added"]);
            exit();
        }
    }
?>
