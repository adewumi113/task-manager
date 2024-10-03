<?php
    error_reporting(E_ALL);
    require_once "Db.php";

    class Task extends Db
    {
        private $dbconn;

        public function __construct(){
            $this->dbconn = $this->connect();
        }


        public function add_task($task_name, $task_start_date, $task_end_date, $taskstatusid, $tasksection, $userid){
            $query = "INSERT INTO tasks (task_name, task_start_date, task_end_date, task_task_status_id, task_section_id, task_creator_user_id) VALUES(?, ?, ?, ?, ?, ?)";
            $stmt = $this->dbconn->prepare($query);
            
            // Execute the task insertion
            $response = $stmt->execute([$task_name, $task_start_date, $task_end_date,  $taskstatusid, $tasksection, $userid]);
        
            if($response){
                // Get the last inserted task ID
                $lastTaskId = $this->dbconn->lastInsertId();
        
                // Automatically assign the task to the user who created it
                $assignResponse = $this->auto_assign_task($lastTaskId, $userid);
        
                if($assignResponse){
                    echo json_encode(["status" => "success", "message" => "Task created successfully"]);
                    return true;
                } else {
                    echo json_encode(["status" => "success", "message" => "Task added, but auto-assignment failed"]);
                    return false;
                }
            }else{
                echo json_encode(["status" => "error", "message" => "Something went wrong"]);
                return false;
            }
        }


        public function auto_assign_task($task_id, $assigntouserid){
            $insertQuery = "INSERT INTO task_assignments (task_assignment_task_id, task_assignment_user_id) VALUES (?, ?)";
            $insertStmt = $this->dbconn->prepare($insertQuery);
            $response = $insertStmt->execute([$task_id, $assigntouserid]);
        
            if($response){
                return true;
            }else{
                return false;
            }
        }
        
        
        public function update_task($taskName, $description, $startDate, $dueDate, $status_id, $section, $taskID)
            {
    
                $query = "UPDATE tasks SET task_name = ?, task_description = ?, task_start_date = ?, task_end_date  = ?, task_task_status_id  = ?, task_section_id  = ? WHERE task_id = ?";
        
                $stmt = $this->dbconn->prepare($query);
        
                $result = $stmt->execute([$taskName, $description, $startDate, $dueDate, $status_id, $section, $taskID]);
        
                if ($result) {
                    return true;
                } else {
                    return false;
                }

        }
            

        public function upload_task_attachments($taskID, $attachedFiles, $userid)
        {
            // Handle file uploads
 
            foreach ($attachedFiles['tmp_name'] as $key => $tempFile) {
                $filename = $attachedFiles['name'][$key];
                $filetype = $attachedFiles['type'][$key];
                $filesize = $attachedFiles['size'][$key];
                $file_tmp_name = $tempFile; // Corrected to use 'tmp_name'

                    // 1. File Size Limit
                    $maxFileSize = 10 * 1024 * 1024; // 10MB
                        if ($filesize > $maxFileSize) {
                            $_SESSION["error_message"] = "File is too big, maximum of " . ($maxFileSize / (1024 * 1024)) . "MB allowed.";
                            return false;
                        }

                    // 2. File Type Validation
                    $allowedTypes = ["image/jpeg", "image/png", "image/jpg", "application/csv", "application/excel", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf"];
                        if (!in_array($filetype, $allowedTypes)) {
                            $_SESSION["error_message"] = "File type not valid, please upload docx/pdf/csv/xlsx/jpeg/jpg/png";
                            return false;
                        }

                    // Unique filename
                    $unique_filename = "taskmasta" . "_" . uniqid() . "_" . $key . "_" . $filename;

                    $destination = "../uploads/task_attachments/" . $unique_filename;

                    // Move the uploaded file
                    if (move_uploaded_file($file_tmp_name, $destination)) {
                        // Insert into the database
                        $query = "INSERT INTO attachments (attachment_task_id, attachment_name, attachment_type, attachment_filepath, attachment_uploadedby_user_id) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $this->dbconn->prepare($query);
                        $result = $stmt->execute([$taskID, $unique_filename, $filetype, $destination, $userid]);

                        if ($result) {
                            $_SESSION["success_message"] = "Task attachment(s) uploaded successfully";
                            return true;
                        } else {
                            $_SESSION["error_message"] = "Task attachment(s) upload failed";
                            return false;
                        }
                        } else {
                            $_SESSION["error_message"] = "Error moving the uploaded file";
                            return false;
                        }
                } 
            }
        

        public function fetch_task($taskid){
            $query = "SELECT t.*, ts.task_status_name AS task_status_name, sec.task_section_name AS task_section_name FROM tasks t LEFT JOIN users u ON t.task_creator_user_id = u.user_id LEFT JOIN task_status ts ON t.task_task_status_id = ts.task_status_id LEFT JOIN task_section sec ON t.task_section_id = sec.Task_section_id WHERE task_id = ?";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([$taskid]);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if($response){
                return $response;
            }else{
                return false;
            }
        }

        public function fetch_alltasks($userid){
            $query = "SELECT DISTINCT t.*, ts.task_status_name , tss.task_section_name, u.user_firstname FROM tasks t LEFT JOIN task_status ts ON t.task_task_status_id = ts.task_status_id LEFT JOIN task_section tss ON t.task_section_id = tss.task_section_id LEFT JOIN task_assignments ta ON t.task_id = ta.task_assignment_task_id LEFT JOIN users u ON u.user_id = t.task_creator_user_id WHERE task_creator_user_id = ? OR ta.task_assignment_user_id = ?";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([$userid, $userid]);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if($response){
                return $response;
            }else{
                return false;
            }
        }

        public function fetch_supervisortasks($userid){
            $query = "SELECT DISTINCT t.*, ts.task_status_name , tss.task_section_name, u.user_firstname FROM tasks t LEFT JOIN task_status ts ON t.task_task_status_id = ts.task_status_id LEFT JOIN task_section tss ON t.task_section_id = tss.task_section_id LEFT JOIN task_assignments ta ON t.task_id = ta.task_assignment_task_id LEFT JOIN users u ON u.user_id = t.task_creator_user_id WHERE task_creator_user_id = ? OR task_approver_id = ? OR ta.task_assignment_user_id = ?";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([$userid, $userid, $userid]);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            if($response){
                return $response;
            } else {
                return false;
            }
        }
        
        
        
        public function fetch_backlogtask($userid, $tasksection){
            $query = "SELECT * FROM tasks WHERE task_creator_user_id = ?  AND task_section_id = ?";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([$userid, $tasksection]);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($response){
                return $response;
            }else{
                return false;
            }
        }

        public function fetch_task_status($task_status_id){
            $query = "SELECT * FROM task_status WHERE task_status_id = ?";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([$task_status_id]);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($response){
                return $response;
            }else{
                return false;
            }
        }

        public function fetch_inprogresstask($userid, $tasksection){
            $query = "SELECT * FROM tasks WHERE task_creator_user_id = ?  AND task_section_id = ?";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([$userid, $tasksection]);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($response){
                return $response;
            }else{
                return false;
            }
        }

        public function fetch_completedtask($userid, $tasksection){
            $query = "SELECT * FROM tasks WHERE task_creator_user_id = ?  AND task_section_id = ?";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([$userid, $tasksection]);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($response){
                return $response;
            }else{
                return false;
            }
        }

        public function fetch_task_attachments($taskid){
            $query = "SELECT * FROM attachments WHERE attachment_task_id = ?";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([$taskid]);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if($response){
                return $response;
            }else{
                return false;
            }
        }

        public function assign_task($task_id, $assigntouserid){
            // Check if the task has already been assigned to the user
            $checkQuery = "SELECT COUNT(*) FROM task_assignments WHERE task_assignment_task_id = ? AND task_assignment_user_id = ?";
            $checkStmt = $this->dbconn->prepare($checkQuery);
            $checkStmt->execute([$task_id, $assigntouserid]);
            $count = $checkStmt->fetchColumn();
        
            if($count > 0){
                // Task already assigned to the user
                echo json_encode(["status" => "error", "message" => "Task has already been assigned to the user"]);
                return false;
            }
        
            // If the task is not assigned to the user, proceed with the insertion
            $insertQuery = "INSERT INTO task_assignments (task_assignment_task_id, task_assignment_user_id) VALUES (?, ?)";
            $insertStmt = $this->dbconn->prepare($insertQuery);
            $response = $insertStmt->execute([$task_id, $assigntouserid]);
        
            if($response){
                $lastInsertId = $this->dbconn->lastInsertId();
                echo json_encode(["status" => "success", "message" => "Task assigned successfully", "assignee" => $lastInsertId]);
                return true;
            }else{
                echo json_encode(["status" => "success", "message" => "Something went wrong"]);
                return false;
            }
        }

        public function fetch_tasksubtask($taskid){
            $query = "SELECT * FROM subtasks WHERE subtask_task_id = ?";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([$taskid]);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if($response){
                return $response;
            }else{
                return false;
            }
        }

        public function fetch_assignee_details($assignmentid){
            $query = "SELECT ta.task_assignment_user_id, CONCAT(u.user_firstname, ' ' , u.user_lastname) AS user_fullname, u.user_profile_picture FROM task_assignments AS ta LEFT JOIN users AS u ON ta.task_assignment_user_id = u.user_id LEFT JOIN tasks AS t ON ta.task_assignment_task_id = t.task_id WHERE task_assignment_task_id = ?";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([$assignmentid]);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if($response){
                return $response;
            }else{
                return false;
            }
        }
        

        public function fetch_task_assignees($taskid){
            $query = "SELECT DISTINCT ta.task_assignment_user_id, CONCAT(u.user_firstname, ' ' , u.user_lastname) AS user_fullname, u.user_profile_picture FROM task_assignments AS ta LEFT JOIN users AS u ON ta.task_assignment_user_id = u.user_id LEFT JOIN tasks AS t ON ta.task_assignment_task_id = t.task_id WHERE task_assignment_task_id = ?";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([$taskid]);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if($response){
                return $response;
            }else{
                return false;
            }
        }

        public function fetch_task_section($user_id) {

            try {
                $query = "SELECT * FROM task_section WHERE task_section_user_id = ? OR task_section_user_id = 0 ";
                $stmt = $this->dbconn->prepare($query);
                $stmt->execute([$user_id]);
                $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if ($response) {
                    return $response;
                } else {

                    return false;
                }
            } catch (PDOException $e) {
                $_SESSION["error_message"] = "Database error: " . $e->getMessage();
                return false;
            }

        }

        public function initiate_task_review($team_lead_id, $task_id) {
            
            try {
                $subtasks = $this->fetch_tasksubtask($task_id);
                if($subtasks){
                    foreach($subtasks as $subtask){
                         // Check if the subtask is completed (checkbox is checked)
                        if ($subtask['subtask_status_id'] != 1) {
                            echo json_encode(["status" => "error", "message" => "Subtasks must be completed before initiating task review"]);
                            return false;
                        }
                    }
                }
                
                $query = "UPDATE tasks SET task_review_status = 'Initiated', task_approval_status = 'Pending', task_approver_id = ? WHERE task_id = ?";
                $stmt = $this->dbconn->prepare($query);
                $response = $stmt->execute([$team_lead_id, $task_id]);
                
                if ($response) {
                    echo json_encode(["status" => "success", "message" => "Task review initiated successfully"]);
                    return true;
                } else {
                    echo json_encode(["status" => "error", "message" => "Something went wrong"]);
                    return false;
                
             }
            } catch (PDOException $e) {
                $_SESSION["error_message"] = "Database error: " . $e->getMessage();
                return false;
            }
        }


        public function approve_task($status_id, $section_id, $task_review_status, $task_approval_status, $task_id)
        {

            $query = "UPDATE tasks SET task_task_status_id  = ?, task_section_id  = ?, task_review_status  = ?, task_approval_status  = ? WHERE task_id = ?";
    
            $stmt = $this->dbconn->prepare($query);
    
            $result = $stmt->execute([$status_id, $section_id, $task_review_status, $task_approval_status, $task_id]);
    
            if ($result) {
                return true;
            } else {
                return false;
            }

        }

        public function return_task($status_id, $section_id, $task_review_status, $task_approval_status, $task_id)
        {

            $query = "UPDATE tasks SET task_task_status_id  = ?, task_section_id  = ?, task_review_status  = ?, task_approval_status  = ? WHERE task_id = ?";
    
            $stmt = $this->dbconn->prepare($query);
    
            $result = $stmt->execute([$status_id, $section_id, $task_review_status, $task_approval_status, $task_id]);
    
            if ($result) {
                return true;
            } else {
                return false;
            }

        }

        public function add_task_comment($taskid, $userid, $comment){
            $query = "INSERT INTO task_comments (task_comment_task_id, task_comment_user_id, task_comment_text) VALUES (?, ?, ?)";
            $insertStmt = $this->dbconn->prepare($query);
            $response = $insertStmt->execute([$taskid, $userid, $comment]);
        
            if($response){
                echo json_encode(["status" => "success", "message" => "<div class='bg-success'>Comment added successfully</div>"]);
                return true;
            }else{
                echo json_encode(["status" => "success", "message" => "Something went wrong"]);
                return false;
            }
        }

        public function edit_task_comment($taskid, $userid, $comment){
            $query = "INSERT INTO task_comments (task_comment_task_id, task_comment_user_id, task_comment_text, ) VALUES (?, ?, ?)";
            $insertStmt = $this->dbconn->prepare($query);
            $response = $insertStmt->execute([$taskid, $userid, $comment]);
        
            if($response){
                echo json_encode(["status" => "success", "message" => "<div class='bg-success'>Comment added successfully</div>"]);
                return true;
            }else{
                echo json_encode(["status" => "success", "message" => "Something went wrong"]);
                return false;
            }
        }

        public function delete_task_comment($taskid, $userid, $comment){
            $query = "INSERT INTO task_comments (task_comment_task_id, task_comment_user_id, task_comment_text, ) VALUES (?, ?, ?)";
            $insertStmt = $this->dbconn->prepare($query);
            $response = $insertStmt->execute([$taskid, $userid, $comment]);
        
            if($response){
                echo json_encode(["status" => "success", "message" => "<div class='bg-success'>Comment added successfully</div>"]);
                return true;
            }else{
                echo json_encode(["status" => "success", "message" => "Something went wrong"]);
                return false;
            }
        }

        public function fetch_task_comments($taskid){
            $query = "SELECT tc.*, CONCAT(u.user_firstname, ' ', u.user_lastname) AS fullname, u.user_profile_picture FROM task_comments tc LEFT JOIN users u ON tc.task_comment_user_id = u.user_id WHERE task_comment_task_id = ?";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([$taskid]);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            if($response){
                return $response;
            }else{
                return false;
            }
        }

        public function update_task_section($status_id, $section_id, $task_id)
        {
            $query = "UPDATE tasks SET task_task_status_id  = ?, task_section_id  = ? WHERE task_id = ?";
    
            $stmt = $this->dbconn->prepare($query);
    
            $result = $stmt->execute([$status_id, $section_id, $task_id]);
    
            if ($result) {
                $_SESSION["success_message"] = "Task updated successfully";
                return true;
            } else {
                $_SESSION["error_message"] = "Something went wrong";
                return false;
            }
        }
        

    }

    $Task = new Task();

?>