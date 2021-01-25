<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../objects/user.php';

    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);


    $userid = $_GET['userid'];
    $password = $_GET['password'];
    $name = $_GET['name'];
    $nid = $_GET['nid'];
    $address = $_GET['address'];
    $latitude = $_GET['latitude'];
    $longitude = $_GET['longitude'];
    $phoneno = $_GET['phoneno'];
    $email = $_GET['email'];
    
    if( !empty($userid) && !empty($password) && !empty($name) && !empty($nid) && !empty($address) && !empty($latitude) && !empty($longitude) && !empty($phoneno) && !empty($email) ){
        $user->userid = $userid;
        $user->password = $password;
        $user->name = $name;
        $user->nid = $nid;
        $user->address = $address;
        $user->latitude = $latitude;
        $user->longitude = $longitude;
        $user->phoneno = $phoneno;
        $user->email = $email;
        
        if ( $user->create() ) {
            http_response_code(200);
            echo json_encode(array("message" => "User was created."));
        } else {
            http_response_code(404);
            echo json_encode(
                array(
                    "message" => "User was not created.",
                )
            );
        }
    } else {
        http_response_code(404);

        echo json_encode(
            array(
                "message" => "Invalid Data",
            )
        );
    }
?>
