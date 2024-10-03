<?php

    error_reporting(E_ALL);
    session_start();
    require_once "../classes/Task.php";
    require_once "../classes/Subtask.php";
    require_once "../classes/User.php";
    require_once "../classes/Attachment.php";
    

    if($_POST && isset($_POST["task_id"]) && isset($_POST["task_name"])){

        $taskName = $_POST["task_name"];
        $taskID = $_POST["task_id"];
        $userID = $_SESSION['user_online'];
        $user = $user1->get_userbyid($_SESSION['user_online']);
        $userteamid = $user['user_team_id'];
        $users = $user1-> fetch_user_team_members($userteamid);
        $userdp = $user['user_profile_picture'];
        
        if(!empty($taskName) || !empty($taskID) || !empty($userID)){
    
            $task = $Task->fetch_task($taskID);

            $attachments = $Task->fetch_task_attachments($taskID);

            $subtasks = $subtask->fetch_subtask($taskID);
            
            $task_section = $Task->fetch_task_section($_SESSION['user_online']);
            
            if($task){

                $str = '<div id="nfeedback"></div>';

                foreach($task as $tsk){

                $str .= '<div class="mx-5"><form method="POST" enctype="multipart/form-data">';
                $str .= '<div class="mb-2 task_id"><p id="task_id" hidden>'. $tsk["task_id"] . '</p><input type="text" class="form-control" name="task_name" id="task_name" value="'. $tsk["task_name"] . '"></div>';
                
                $str .= '<div class="d-flex mb-2 justify-content between align-items-center"><p class="w-25">Assignee</p>';
                $task_assignees = $Task->fetch_task_assignees($taskID);
                
                if($task_assignees){
                    foreach ($task_assignees as $task_assignedto){
                
                        if (!empty($task_assignedto['user_profile_picture'])) {
                            $str .= '<div class="rounded-circle pe-2" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="' . $task_assignedto['user_fullname'] . '">';
                            $str .= '<img src="uploads/' . $task_assignedto['user_profile_picture'] . '" class="rounded-circle" height="30" width="30" style="margin: -10px;" alt="Avatar" loading="lazy">';
                            $str .= '</div>';
                        }
                    }
    
                }
                $str .= '<i class="btn fa fa-users users-icon me-3" id="assign_btn"></i>';
                
                $str .= '<select class="form-control d-none" id="assign_to" name="assign_to">';
                foreach($users as $user){
                    $str .= '<option value="'. $user['user_id'] . '">' . $user['user_firstname'] . ' ' . $user['user_lastname'] . ' ('. $user['user_email'] . ')' . '</option>';
                }
                $str .= '</select></div>';
                   

                $str .= '<div class="d-flex"><div class="col-6">';

                $str .= '<div class="d-flex mb-2"><label for="task_due_date" style="width:135px">Due date</label><input type="date" class="form-control w-50 border border-white" value="'. $tsk["task_end_date"] . '" id="task_due_date" name="task_due_date"></div>';
               
                $str .= '<div class="d-flex mb-2"><label for="task_section" style="width:135px">Section</label><select class="form-control w-50" id="task_section" name="task_section">';

                foreach ($task_section as $section) {
                    $selected = ($section['task_section_id'] == $tsk['task_section_id']) ? 'selected' : '';
                    $str .= '<option value="' . $section['task_section_id'] . '" ' . $selected . '>' . $section['task_section_name'] . '</option>';
                }

                $str .= '</select></div>';

                $str .= '<div class="d-flex mb-2"><label for="task_status" style="width:135px">Status</label><input type="text" class="form-control w-50 border border-white" value="'. $tsk["task_status_name"] . '" id="task_status" name="task_status" readonly></div>';

                $str .= '</div><div class="col-6">';

                $str .= '<div class="d-flex mb-2"><label for="task_start_date" style="width:135px">Start date</label><input type="date" class="form-control w-50 border border-white" value="'. $tsk["task_start_date"] . '" id="task_start_date" name="task_start_date"></div>';

                $str .= '<div class="d-flex mb-2"><label for="task_review_status" style="width:135px">Review status</label><input type="text" class="form-control w-50 border border-white" value="'. $tsk["task_review_status"] . '" id="task_review_status" name="task_review_status"  readonly></div>';

                $str .= '<div class="d-flex mb-2"><label for="task_approval_status" style="width:135px">Approval status</label><input type="text" class="form-control w-50 border border-white" value="'. $tsk["task_approval_status"] . '" id="task_approval_status" name="task_approval_status"  readonly></div>';

                $str .= '</div></div>';

                $str .= '<div class="d-flex"><label for="task_description" class="w-25">Description</label><textarea class="form-control" rows="3" placeholder="What is the task about?" value="'. $tsk["task_description"] . '"  name="task_description" id="task_description" >';
                
                if($tsk["task_description"] !== ""){
                    $str .= $tsk["task_description"];
                } 
                
                $str .= '</textarea></div>';

                if(!empty($attachments)){
                    $str .= '<div class="my-2 align-items-center bg-light px-2" id="attachments"> <h6 class="p-2">Attachments</h6>';
                    foreach($attachments as $attachment){
                        $str .= '<a href="uploads/task_attachments/'. $attachment['attachment_name'] . '" target="_blank">'. $attachment['attachment_name'] . '</a>';
                    }
                    $str .= '</div>';
                }

                if (!empty($subtasks)) {
                    $str .= '<div class="my-2 align-items-center bg-light px-2 subtaskdetails"> <h6 class="p-2">Subtasks</h6>';
                    foreach ($subtasks as $subtask) {
                        $str .= '<div class="d-flex align-items-center subtask-item mb-2">';
                        $str .= '<input type="text" class="subtask_id2" id="subtask_id2" hidden value="' . $subtask["subtask_id"] . '">';
                        if($subtask["subtask_status_id"] == 1){

                        $str .= '<input type="checkbox" class="form-check-input me-2 subtask_checkbox2" id="subtask_checkbox2" style="width:20px; height:20px; border:1px solid gray" checked>';
                        }else{
                            $str .= '<input type="checkbox" class="form-check-input me-2 subtask_checkbox2" id="subtask_checkbox2" style="width:20px; height:20px; border:1px solid gray">';
                        }

                        $str .= '<input type="text" class="form-control me-3 subtask_name2 w-50" value="' . $subtask["subtask_name"] . '" id="subtask_name2">';
                        if($subtask["subtask_end_date"] == '0000/00/00'){
                            $str .= '<input type="date" class="form-control me-3 subtask_end_date2" id="subtask_end_date2" style="width:150px;">';
                        }
                        else
                        {$str .= '<input type="date" class="form-control me-3 subtask_end_date2" value="' . $subtask["subtask_end_date"] . '" style="width:150px;" id="subtask_end_date2"></div>';
                        
                        }
                        // $str .= '<i class="fa fa-users users-icon me-3"></i><i class="fas fa-comment comment-icon"></i><i class="fas fa-comment comment-icon"></i>';
                        
                    }
                }

                $str .= '</div>';

                $str .= '<div class="d-flex my-2 align-items-center bg-light px-2 subtask d-none"><input type="checkbox" id="subtask_checkbox" class="form-check-input me-2 subtask_checkbox" style="width:20px; height:20px; border:1px solid gray">
                <input type="text" class="form-control me-3 subtask_name" placeholder="Input subtask name"><input type="date" class="me-3 subtask_end_date" id="subtask_end_date" style="width:30px;"><i class="fa fa-users users-icon me-3"></i><i class="fas fa-comment comment-icon"></i></div>';

                $str .= '<div class="d-flex"> <button type="button" class="btn btn-secondary-subtle mt-2 me-2" id="add_attachment" name="add_attachment"><i class="fa fa-paperclip me-2"></i>Attach a file</button>';

                $str .= '<input type="file" class="d-none form-control m-2" name="attachment_file[]"  style="width:250px;" id="attached_files"  multiple>';  // File input for attachments (hidden initially)
                
                $str .= '<button type="button" class="btn btn-secondary mt-2 me-2" id="add_subtask" name="add_subtask"></i>Add subtask</button>';
                
                $str .= '<button type="button" class="btn btn-primary mt-2 me-2" id="update_task_btn" name="update_task_btn" value="update_task_btn">Update task</button>';
                if($_SESSION["user_role_id"] < 5){
                  
                    $str .= '<button type="button" class="btn btn-danger mt-2 mx-2" id="return_task" name="return_task">Return</button>';
                    
                    $str .= '<button type="button" class="btn btn-success mt-2" id="approve_task" name="approve_task">Approve</button></div>';
                }else{
                    
                    if($tsk['task_section_id']==2 ){
                    $str .= '<button type="button" class="btn btn-info mt-2" id="initiate_task_review" name="initiate_task_review">Initiate Review</button></div>';
                    }
                }
                $str .= '</form></div>';

                $task_comments = $Task->fetch_task_comments($taskID);
                if(!empty($task_comments)){
                    $str .= '<div class="my-2 align-items-center bg-light px-2 allcomments"> <h5 class="p-2 fw-bold ">Comments</h5>';
                    foreach ($task_comments as $comment){

                        $str .= '<div class="d-flex align-items-center comment mb-2">';
                        $str .= '<div class="rounded-circle pe-2" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="' . $comment['fullname'] . '">';
                        $str .= '<img src="uploads/' . $comment['user_profile_picture'] . '" class="rounded-circle" height="30" width="30" alt="Avatar" loading="lazy">';
                        $str .= '</div>';
                        $str .= '<p class="my-2"><span class="fw-bold mx-2">' . $comment['fullname'];
                        $str .= '</span>';
                        $str .= '<span class="mx-2">' . $comment['task_comment_date'] . '</span>'; 
                        $str .= '</p></div>';
                        $str .= '<textarea class="form-control mb-2" rows="2" readonly>' . $comment['task_comment_text'] . '</textarea>';
                        
                    }
                    $str .= '</div>';
                    
                }
            }
                
                echo $str;
            }else{
                $_SESSION['error_message'] = "Something went wrong!!!";
                // header("location: ../mytasks.php");
                exit();
            }
            }
        }else{
            $_SESSION["error_message"] = "Please select a task...";
            header("location: ../mytasks.php");
            exit();
        }

?>