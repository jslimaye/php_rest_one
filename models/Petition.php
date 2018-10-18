<?php

    class Petition{
        //DB stuff
        private $conn;
        private $table = 'petitions';

        //post props
        public $id;
        public $userid;
        public $title;
        public $date_time_created;
        public $target_date;
        public $target_votes;
        public $username;
        public $description;
        public $up_votes;
        public $down_votes;

        //constructor
        function __construct($db){
            $this->conn = $db;
        }

        //read
        public function read(){
            //create query

            $query = 'SELECT u.username,
            p.petition_id as id,
            p.category_id as category_id,
            p.usr_id as userid,
            p.target_date,
            p.target_votes,
            p.date_time_created,
            p.description, 
            p.title
            FROM 
            ' . $this->table . ' p 
            JOIN 
                users u ON 
                p.usr_id = u.usr_id 
            ORDER BY 
                p.date_time_created DESC
            LIMIT 50';

            //PERPARE STMT
            $stmt = $this->conn->prepare($query);
            
            //excecute stmt
            $stmt->execute();

            return $stmt;
        }
        
        public function get_up_votes($id){
            $query = 'SELECT COUNT(*) as up_votes from votes where petition_id ='.$id.' and status = 0';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function get_down_votes($id){
            $query = 'SELECT COUNT(*) as down_votes from votes where petition_id ='.$id.' and status = 1';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    }
        
        


    