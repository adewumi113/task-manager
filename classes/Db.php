<?php

    require_once('config.php');

    class Db{

        private $dbhost = DBHOST;
        private $dbname = DBNAME;
        private $dbuser = DBUSER;
        private $dbpass = DBPASS;

        protected $conn;

        protected function connect(){
            $dsn = "mysql:host=$this->dbhost;dbname=$this->dbname";
            $option = [
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
            ];

            try{
                $this->conn = new PDO($dsn, $this->dbuser, $this->dbpass, $option);
                return $this->conn;
            }catch(Exception $e){
                $e->getMessage();
                return false;
            }

        }



}

?>