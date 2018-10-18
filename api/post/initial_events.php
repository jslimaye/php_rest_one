<?php 

    //headers
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Event.php';


    //Instansiate Database and connection
    $database = new Database();
    $db = $database->connect();


    //Instansiate eventition Object
    $eventition = new Event($db);

    //eventition query
    $result = $eventition -> read();

    //row count
    $num = $result->rowCount();

    //check if any event
    if($num > 0){
        //events Array
        $event_arr = array();
        $event_arr['number'] = $num;
        $event_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $event_item = array(
                'id' => $id,
                'title' => $title,
                'username' => $username,
                'usr_id' => $userid,
                'venue' => $venue,
                'details' => $details,
                'event_time' => $date_time
            );

            array_push($event_arr['data'],$event_item);
        }

        //put to json
        echo json_encode($event_arr);
    }else{
        echo json_encode(
            array('message'=>'No Data')
        );
    }
