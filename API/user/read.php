<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/user.php';

    // instantiate database and product object
    $database = new Database();
    $db = $database->getConnection();

    // initialize object
    $user = new User($db);

    $searchId = isset($_GET["id"]) ? $_GET["id"] : "";

    // query users
    $stmt = $user->read($searchId);
    $num = $stmt->rowCount();

    // check if more than 0 record found
    if($num == 1){
        // users array
        $users_arr=array();
        $users_arr["users"]=array();

        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
            $user_item = array(
                "userid" => $userid,
                "password" => $password,
                "name" => $name,
                "avatar" => $avatar,
                "nid" => $nid,
                "type" => $type,
                "address" => $address,
                "latitude" => $latitude,
                "longitude" => $longitude,
                "phoneno" => $phoneno,
                "email" => $email,
            );

            array_push($users_arr["users"], $user_item);
        }

        // set response code - 200 OK
        http_response_code(200);

        // show users data in json format
        echo json_encode($user_item);
    } else {

        // set response code - 404 Not found
        http_response_code(404);

        // tell the user no users found
        echo json_encode(
            array("message" => "No users found.")
        );
    }
?>
