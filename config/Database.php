<?php
    class   Database{
        //DB params
        private $host = "localhost";
        private $dbname = "call_for_cause";
        private $username = "root";
        private $pass = "";
        private $conn;

        public function connect(){
            $this->conn = null;


            try {
                $this->conn = new PDO('mysql:host='.$this->host.';dbname='. $this->dbname,
                $this->username,$this->pass);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo 'connection Error'.$e->getMessage();
            }

            return $this->conn;
        }
    }

