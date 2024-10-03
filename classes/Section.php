<?php
    error_reporting(E_ALL);
    require_once "Db.php";

    class Section extends Db
    {
        private $dbconn;

        public function __construct(){
            $this->dbconn = $this->connect();
        }

        public function add_section($userid, $section_name){
            $query = "INSERT INTO tasks (task_name, task_start_date, task_end_date, task_creator_user_id) VALUES(?, ?, ?, ?)";
            $stmt = $this->dbconn->prepare($query);
            $response = $stmt->execute([$userid, $section_name]);
            if($response){
                $_SESSION["success_message"] = "Section added successfully";
                return true;
            }else{
                $_SESSION["error_message"] = "Something went wrong";
                return false;
            }
        }

        public function create_section($section_name, $userid){
            $query = "INSERT INTO task_section (task_section_name, task_section_user_id) VALUES(?, ?)";
            $stmt = $this->dbconn->prepare($query);
            $response = $stmt->execute([$section_name, $userid]);
            if($response){
                $_SESSION["success_message"] = "Section added successfully";
                return true;
            }else{
                $_SESSION["error_message"] = "Something went wrong";
                return false;
            }
        }   
        
        public function fetch_sections(){
            $query = "SELECT * FROM task_section";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($response){
                return $response;
            }else{
                return false;
            }
        }
        

    }

    $Section = new Section();

?>