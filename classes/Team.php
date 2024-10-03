<?php

    error_reporting(E_ALL);
    require_once('Db.php');

    class Team extends Db{

        private $dbconn;

        public function __construct(){
            $this->dbconn = $this->connect();
        }

        public function fetch_allteams(){
            $sql = "SELECT * FROM team";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $teams;
        }

        public function fetch_teamlead($team_id){
            $sql = "SELECT user_id, user_firstname, user_lastname FROM users WHERE user_team_id = ? AND user_role_id = 4";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$team_id]);
            $teamlead = $stmt->fetch(PDO::FETCH_ASSOC);

            if($teamlead){
                return $teamlead;
            }else{
                return false;
            }
        }

    }

    $team = new Team();

?>