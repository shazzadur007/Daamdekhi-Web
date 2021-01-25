<?php
    class Product {

        // database connection and table name
        private $conn;
        private $table_name = "products";

        // object properties

        public $productId;
        public $name;
        public $price;
        public $desc;
        public $meta;
        public $latitude;
        public $longitude;
        public $sellerId;
        public $ratingId;

        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        // read products
        function read(){
            $id=htmlspecialchars(strip_tags($id));
            $query = "SELECT `productId`, `name`, `price`, `desc`, `meta`, `latitude`, `longitude`, `sellerId`, `ratingId` FROM `products`";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }
        
        // read products
        function readByCategory($category){
            $id=htmlspecialchars(strip_tags($id));
            $query = "SELECT `productId`, `name`, `price`, `desc`, `meta`, `latitude`, `longitude`, `sellerId`, `ratingId` FROM `products` WHERE `meta`= '". $category ."'";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }
        
        
        function readsingle($id){
            $id=htmlspecialchars(strip_tags($id));
            $query = "SELECT `productId`, `name`, `price`, `desc`, `meta`, `latitude`, `longitude`, `sellerId`, `ratingId` FROM `products` WHERE `productId`='".$id."'";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }

        // Create Transection
        function create(){
            // sanitize
            $this->productId = htmlspecialchars(strip_tags($this->productId));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->price = htmlspecialchars(strip_tags($this->price));
            $this->desc = htmlspecialchars(strip_tags($this->desc));
            $this->meta = htmlspecialchars(strip_tags($this->meta));
            $this->latitude = htmlspecialchars(strip_tags($this->latitude));
            $this->longitude = htmlspecialchars(strip_tags($this->longitude));
            $this->sellerId = htmlspecialchars(strip_tags($this->sellerId));
            $this->ratingId = htmlspecialchars(strip_tags($this->ratingId));

            // select all
            $query1 = "INSERT INTO `transections` SET `senderAccNo`='".$this->senderAccNo."', `recieverAccNo`='".$this->recieverAccNo."', `traxAmount`='".$this->traxAmount."'";
            $query2 = "UPDATE `users` SET `currentBalance` = `currentBalance` - ". ($this->traxAmount + $this->traxAmount * 0.15) ." WHERE `accountId` = '".$this->senderAccNo."'";
            $query3 = "UPDATE `users` SET `currentBalance` = `currentBalance` + ".$this->traxAmount." WHERE `accountId` = '".$this->recieverAccNo."'";

            // prepare query statement
            $stmt1 = $this->conn->prepare($query1);
            $stmt2 = $this->conn->prepare($query2);
            $stmt3 = $this->conn->prepare($query3);

            // execute query
            if($stmt1->execute() && $stmt2->execute() && $stmt3->execute()){
                return true;
            }
            return false;
        }
    }
?>
