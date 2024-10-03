<?php

    error_reporting(E_ALL);
    require_once('Db.php');

    class Job extends Db{

        private $dbconn;

        public function __construct(){
            $this->dbconn = $this->connect();
        }

        public function fetch_alljobs(){
            $sql = "SELECT * FROM job_title";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $jobs;
        }
    }

    $job = new Job();

?>