<?php

    error_reporting(E_ALL);
    require_once "Db.php";

    class Subtask extends Db
    {
        private $dbconn;

        public function __construct(){
            $this->dbconn = $this->connect();
        }

        public function add_subtask($taskid, $subtaskname, $subtaskenddate, $subtaskstatusid, $userid){
            // Check if the subtask name already exists for the given task ID
            $checkQuery = "SELECT COUNT(*) as count FROM subtasks WHERE subtask_task_id = ? AND subtask_name = ?";
            $checkStmt = $this->dbconn->prepare($checkQuery);
            $checkStmt->execute([$taskid, $subtaskname]);
            $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
            if ($result['count'] > 0) {
                // Subtask name already exists
                echo json_encode(["status" => "error", "message" => "Subtask name already exists"]);
                return false;
                return false;
            }
        
            // If the subtask name does not exist, proceed to insert the data
            $query = "INSERT INTO subtasks (subtask_task_id, subtask_name, subtask_end_date, subtask_status_id) VALUES(?, ?, ?, ?)";
            $stmt = $this->dbconn->prepare($query);
            $response = $stmt->execute([$taskid, $subtaskname, $subtaskenddate, $subtaskstatusid]);
        
            if($response){
                // Subtask added successfully
                echo json_encode(["status" => "success", "message" => "Subtask added successfully"]);
                return true;
            } else {
                // Something went wrong
            echo json_encode(["status" => "error", "message" => "Something went wrong"]);
            return false;
            }
        }
        

        public function fetch_subtask($taskid){
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

        public function update_subtask($subtaskName, $subtaskDueDate, $subtaskStatusId, $subtaskId)
            {
    
                $query = "UPDATE subtasks SET subtask_name = ?, subtask_end_date  = ?, subtask_status_id  = ? WHERE subtask_id = ?";
        
                $stmt = $this->dbconn->prepare($query);
        
                $result = $stmt->execute([$subtaskName, $subtaskDueDate, $subtaskStatusId, $subtaskId]);
        
                if ($result) {
                    $_SESSION["success_message"] = "Subtask updated successfully";
                    return true;
                } else {
                    $_SESSION["error_message"] = "Something went wrong";
                    return false;
                }

        }
    }

    $subtask = new Subtask();
?>