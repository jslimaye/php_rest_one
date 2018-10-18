<?php

    class Event{
        //DB stuff
        private $conn;
        private $table = 'events_cfc';
    
        

        //post props
        public $id;
        public $userid;
        public $title;
        public $date_time;
        public $venue;
        public $username;
        public $details;
        

        //constructor
        function __construct($db){
            $this->conn = $db;
        }

        //read
        public function read(){
            //set time
            $date = date_create();
            $ts = date_timestamp_get($date);

            //create query
            $query = 'SELECT u.username,
            e.event_id as id,
            e.usr_id as userid,
            e.details,
            e.venue,
            e.date_time, 
            e.event_title as title
            FROM 
            ' . $this->table . ' e 
            JOIN 
                users u ON 
                e.usr_id = u.usr_id 
            ORDER BY 
                e.date_time
            WHERE
                e.date_time >' . $ts . '
            LIMIT 25';

            //PERPARE STMT
            $stmt = $this->conn->prepare($query);
            
            //excecute stmt
            $stmt->execute();

            return $stmt;
        }
        
        
    }
        
        


    