<?php

    error_reporting(E_ALL);
    session_start();
    require_once "../classes/Task.php";

    if($_POST && isset($_POST["task_id"])){

        $taskid = $_POST["task_id"];

        if(!empty($taskid)){
            $comments = $Task->fetch_task_comments($taskid);
            
            if($comments){
                print_r($comments);
                die();
                foreach($subtasks as $subtask){
                $str = '<div>';
                $str .= '<div id="comment_user_image" class="me-2"><img src=""></div>';
                $str .= '<div class="username_date d-flex"><p class="me-3 comment_user_name">' . $subtask['task_comment_user_id'] . '</p>';
                $str .= '<p class="comment_date" >' . $subtask['task_comment_date'] . '</p></div>';
                $str .= '<p class="comment_text" >' .$subtask['task_comment_text'] . '</p></div>';
                }
                echo $str;
            }else{
                echo "";
                exit();
            }

        }else{
            $_SESSION["error_message"] = "Please input a comment...";
            exit();
        }

    }
?>