<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/product.php';

    // instantiate database and product object
    $database = new Database();
    $db = $database->getConnection();

    // initialize object
    $product = new Product($db);

    $id = isset($_GET["id"]) ? $_GET["id"] : "";

    // query product
    $stmt = $product->readsingle($id);
    $num = $stmt->rowCount();

    // check if more than 0 record found
    if($num > 0){
        // product array
        $product_arr=array();

        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);

            $product_item = array(
                "productId" => $productId,
                "name" => $name,
                "price" => $price,
                "desc" => $desc,
                "meta" => $meta,
                "sellerId" => $sellerId,
                "ratingId" => $ratingId,
            );

            array_push($product_arr, $product_item);
        }

        // set response code - 200 OK
        http_response_code(200);
        $products = array("products" => $product_arr, "message" => "ok");
        // show product data in json format
        echo json_encode($products);
    } else {

        // set response code - 404 Not found
        http_response_code(404);

        // tell the user no product found
        echo json_encode(
            array("message" => "No product found.")
        );
    }
?>
