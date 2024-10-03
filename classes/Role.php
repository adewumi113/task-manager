<?php

    error_reporting(E_ALL);
    require_once('Db.php');

    class Role extends Db{

        private $dbconn;

        public function __construct(){
            $this->dbconn = $this->connect();
        }

        public function fetch_allroles(){
            $sql = "SELECT * FROM user_roles";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $roles;
        }
    }

    $role = new Role();

?>