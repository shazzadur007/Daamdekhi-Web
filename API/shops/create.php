<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../objects/shops.php';

    $database = new Database();
    $db = $database->getConnection();
    $shop = new Shop($db);


    $shopname = $_GET['shopname'];
    $name = $_GET['name'];
    $phone = $_GET['phone'];
    $mail = $_GET['mail'];
    
    if( !empty($shopname) && !empty($name) && !empty($phone) && !empty($mail) ){
        $shop->shopname = $shopname;
        $shop->name = $name;
        $shop->phone = $phone;
        $shop->mail = $mail;
        
        if ( $shop->create() ) {
            http_response_code(200);
            echo json_encode(array("message" => "Shop was created."));
        } else {
            http_response_code(404);
            echo json_encode(
                array(
                    "message" => "Shop was not created.",
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
