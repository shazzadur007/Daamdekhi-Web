<?php
    class Shop {

        // database connection and table name
        private $conn;
        private $tableName = "shops";

        // object properties
        public $shopid;
        public $shopname;
        public $name;
        public $phone;
        public $mail;

        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        // read user
        function read(){
            $query = "SELECT `shopid`, `shopname`, `name`, `phone`, `mail` FROM " . $this->tableName ." WHERE `approved`=1";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }
        
        function create(){
            $this->shopname = htmlspecialchars(strip_tags($this->shopname));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->phone = htmlspecialchars(strip_tags($this->phone));
            $this->mail = htmlspecialchars(strip_tags($this->mail));
            
            $query = "INSERT INTO `".$this->tableName."` SET `shopname`='".$this->shopname."', `name`='".$this->name."', `phone`='".$this->phone."', `mail`='".$this->mail."', `approved`=0";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // execute query
            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }
?>
