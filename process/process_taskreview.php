<?php

    error_reporting(E_ALL);
    session_start();
    require_once "../classes/Task.php";
    require_once "../classes/Subtask.php";
    require_once "../classes/User.php";

    if($_GET && isset($_GET["task_id"]) && isset($_GET["task_name"])){

        $taskName = $_GET["task_name"];
        $taskID = $_GET["task_id"];
        $userID = $_SESSION['user_online'];
        $user = $user1->get_userbyid($_SESSION['user_online']);
        $users = $user1->fetch_allusers();
        $userdp = $user['user_profile_picture'];

        if(!empty($taskName) || !empty($taskID) || !empty($userID)){
            $task = $Task->fetch_task($userID, $taskID);
            $subtasks = $subtask->fetch_subtask($taskID);
            $task_section = $Task->fetch_task_section($_SESSION['user_online']);
            
            if($task){
                // echo "<pre>";
                // print_r($task);
                // echo "</pre>";
                // die();<input type="text" class="form-control border border-white" id="task_assignee" name="task_assignee" value="'. $tsk["full_name"] . '">

                foreach($task as $tsk)
                $str = '<div class="mx-5"><form>';
                $str .= '<div class="mb-2 task_id"><p id="task_id" hidden>'. $tsk["task_id"] . '</p><input type="text" class="form-control" value="'. $tsk["task_name"] . '"><p id="feedback"></p></div>';
                $str .= '<div  class="d-flex mb-2 justify-content between align-items-center"><p class="w-25">Assignee</p><div class="rounded-circle pe-2"><img src="uploads/' . $userdp . '" class="rounded-circle" height="30" width="30" alt="Avatar" loading="lazy"></div><i class="btn fa fa-users users-icon me-3" id="assign_btn"></i>';
                
                $str .= '<select class="form-control d-none" id="assign_to">';
                foreach($users as $user)
                $str .= '<option value="'. $user['user_id'] . '">' . $user['user_firstname'] . ' ' . $user['user_lastname'] . ' ('. $user['user_email'] . ')' . '</option>';
                
                $str .= '</select></div>';

                $str .= '<div class="d-flex"><div class="col-6">';

                $str .= '<div class="d-flex mb-2"><label for="task_due_date" style="width:135px">Due date</label><input type="date" class="form-control w-50 border border-white" value="'. $tsk["task_end_date"] . '" id="task_due_date" name="task_due_date"></div>';
               
                $str .= '<div class="d-flex mb-2"><label for="task_section" style="width:135px">Section</label><select class="form-control w-50" id="task_section" name="task_section">';

                foreach ($task_section as $section) {
                    $selected = ($section['task_section_id'] == $tsk['task_section_id']) ? 'selected' : '';
                    $str .= '<option value="' . $section['task_section_id'] . '" ' . $selected . '>' . $section['task_section_name'] . '</option>';
                }

                $str .= '</select></div>';

                $str .= '<div class="d-flex mb-2"><label for="task_status" style="width:135px">Status</label><input type="text" class="form-control w-50 border border-white" value="'. $tsk["task_status_name"] . '" id="task_status" name="task_status"></div>';

                $str .= '</div><div class="col-6">';

                $str .= '<div class="d-flex mb-2"><label for="task_start_date" style="width:135px">Start date</label><input type="date" class="form-control w-50 border border-white" value="'. $tsk["task_start_date"] . '" id="task_start_date" name="task_start_date"></div>';
                $str .= '<div class="d-flex mb-2"><label for="task_review_status" style="width:135px">Review status</label><input type="text" class="form-control w-50 border border-white" value="'. $tsk["task_review_status"] . '" id="task_review_status" name="task_review_status"></div>';
                $str .= '<div class="d-flex mb-2"><label for="task_approval_status" style="width:135px">Approval status</label><input type="text" class="form-control w-50 border border-white" value="'. $tsk["task_approval_status"] . '" id="task_approval_status" name="task_approval_status"></div>';
                $str .= '</div></div>';
                $str .= '<div class="d-flex"><label for="task_description" class="w-25">Description</label><textarea class="form-control" rows="3" placeholder="What is the task about?" value="'. $tsk["task_description"] . '"></textarea></div>';

                if (!empty($subtasks)) {
                    $str .= '<div class="my-2 align-items-center bg-light px-2 subtaskdetails"> <h6 class="p-2">Subtasks</h6>';
                    foreach ($subtasks as $subtask) {
                        $str .= '<div class="d-flex align-items-center subtask-item mb-2">';
                        $str .= '<input type="checkbox" class="form-check-input me-2" style="width:20px; height:20px; border:1px solid gray">';
                        $str .= '<input type="text" class="form-control me-3" value="' . $subtask["subtask_name"] . '" disabled>';
                        if($subtask["subtask_end_date"] = '0000/00/00'){
                            $str .= '<input type="date" class="me-3" id="subtask_end_date" style="width:30px;">';
                        }
                        else
                        {$str .= '<input type="date" class="me-3" value="' . $subtask["subtask_end_date"] . '" style="width:150px;">';
                        
                        }
                        $str .= '<i class="fa fa-users users-icon me-3"></i><i class="fas fa-comment comment-icon"></i><i class="fas fa-comment comment-icon"></i></div>';
                        
                    }
                }

                $str .= '</div>';

                $str .= '<div class="d-flex my-2 align-items-center bg-light px-2 subtask d-none"><input type="checkbox" id="subtask_checkbox" class="form-check-input me-2" style="width:20px; height:20px; border:1px solid gray">
                <input type="text" class="form-control me-3 subtask_name" placeholder="Input subtask name"><input type="date" class="me-3" id="subtask_end_date" style="width:30px;"><i class="fa fa-users users-icon me-3"></i><i class="fas fa-comment comment-icon"></i></div>';

                $str .= '<div class="d-flex"> <button type="button" class="btn btn-secondary-subtle mt-2 me-2" id="attachment" name="add_attachment"><i class="fa fa-paperclip me-2"></i>Attach a file</button>';
                
                $str .= '<button type="button" class="btn btn-secondary mt-2 me-2" id="add_subtask" name="add_subtask"><i class="fa fa-plus me-2"></i>Add subtask</button>';
                
                $str .= '<button type="button" class="btn btn-primary mt-2 me-2" id="update_task_btn" name="update_task_btn">Update task</button>';

                $str .= '<button type="button" class="btn btn-success mt-2" id="initiate_task_review" name="initiate_task_review">Initiate Review</button></div>';
                $str .= '</form></div>';
                       
                echo $str;
            }else{
                $_SESSION['error_message'] = "Something went wrong!!!";
                // header("location: ../mytasks.php");
                exit();
            }

        }else{
            $_SESSION["error_message"] = "Please select a task...";
            header("location: ../mytasks.php");
            exit();
        }

    }
?>