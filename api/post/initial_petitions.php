<?php 

    //headers
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: applicaation/json');

    include_once '../../config/Database.php';
    include_once '../../models/Petition.php';


    //Instansiate Database and connection
    $database = new Database();
    $db = $database->connect();


    //Instansiate Petition Object
    $petition = new Petition($db);

    //Petition query
    $result = $petition -> read();

    //row count
    $num = $result->rowCount();

    //check if any petitions
    if($num > 0){
        //Petition Array
        $pet_arr = array();
        $pet_arr['number'] = $num;
        $pet_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $up_votes_result = $petition->get_up_votes($id);
            $down_votes_result = $petition->get_down_votes($id);

            $uv = $up_votes_result->fetch(PDO::FETCH_ASSOC);
            extract($uv);
            $dv = $down_votes_result->fetch(PDO::FETCH_ASSOC);
            extract($dv);
            
            $pet_item = array(
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'username' => $username,
                'up_votes' => $up_votes,
                'down_votes' => $down_votes,
                'target_date' => $target_date,
                'target_votes' => $target_votes,
                'created_at' => $date_time_created
            );

            array_push($pet_arr['data'],$pet_item);
        }

        //put to json
        echo json_encode($pet_arr);
    }else{
        echo json_encode(
            array('message'=>'No Data')
        );
    }
