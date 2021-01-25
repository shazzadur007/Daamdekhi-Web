<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/shops.php';

    $database = new Database();
    $db = $database->getConnection();

    $product = new Shop($db);

    $stmt = $product->read();
    $num = $stmt->rowCount();

    if($num > 0){
        $shop_arr=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $shop_single = array(
                "shopid" => $shopid,
                "shopname" => $shopname,
                "name" => $name,
                "phone" => $phone,
                "mail" => $mail,
            );

            array_push($shop_arr, $shop_single);
        }

        http_response_code(200);
        echo json_encode(array("Shops" => $shop_arr));
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No shop found.")
        );
    }
?>
