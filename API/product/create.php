<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../objects/trax.php';
    include_once '../objects/user.php';

    $database = new Database();
    $db = $database->getConnection();
    $trax = new Transection($db);
    $user = new User($db);


    $senderAccNo = $_GET['senderAccNo'];
    $recieverAccNo = $_GET['recieverAccNo'];
    $traxAmount = $_GET['traxAmount'];
    $stmt = $user->balance($senderAccNo);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $balance = $currentBalance;
    }
    
    if( !empty($senderAccNo) && !empty($recieverAccNo) && !empty($traxAmount) ){
        if ( $balance > ($traxAmount + $traxAmount *.15) ) {
            $trax->senderAccNo = $senderAccNo;
            $trax->recieverAccNo = $recieverAccNo;
            $trax->traxAmount = $traxAmount;
            if ( $trax->create() ) {
                http_response_code(200);
                echo json_encode(array("message" => "Trasection was successful."));
            } else {
                http_response_code(404);
                echo json_encode(
                    array(
                        "message" => "Trasection was unsuccessful.",
                    )
                );
            }
        } else {
            http_response_code(404);
            echo json_encode(
                array(
                    "message" => "Not enough balance.",
                    "balance" => $balance,
                )
            );
        }
    } else {

        // set response code - 404 Not found
        http_response_code(404);

        echo json_encode(
            array(
                "message" => "Invalid Data",
                "Trax" => $trax,
            )
        );
    }
?>
