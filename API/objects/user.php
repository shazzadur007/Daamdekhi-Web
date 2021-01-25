<?php
    class User {

        // database connection and table name
        private $conn;
        private $tableName = "users";

        // object properties
        public $userid;
        public $password;
        public $name;
        public $avatar;
        public $nid;
        public $type;
        public $address;
        public $latitude;
        public $longitude;
        public $phoneno;
        public $email;

        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        // read user
        function read($searchId){
            $searchId=htmlspecialchars(strip_tags($searchId));

            $query = "SELECT `userid`, `password`, `name`, `avatar`, `nid`, `type`, `address`, `latitude`, `longitude`, `phoneno`, `email` FROM " . $this->tableName . " WHERE `userid`='$searchId'";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }
        
        function create(){
            $this->userid = htmlspecialchars(strip_tags($this->userid));
            $this->password = md5($this->password);
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->avatar = 'dummy.jpg';
            $this->nid = htmlspecialchars(strip_tags($this->nid));
            $this->type = 'user';
            $this->address = htmlspecialchars(strip_tags($this->address));
            $this->latitude = htmlspecialchars(strip_tags($this->latitude));
            $this->longitude = htmlspecialchars(strip_tags($this->longitude));
            $this->phoneno = htmlspecialchars(strip_tags($this->phoneno));
            $this->email = htmlspecialchars(strip_tags($this->email));
            
            $query = "INSERT INTO `".$this->tableName."` SET `userid`='".$this->userid."', `password`='".$this->password."', `name`='".$this->name."', `avatar`='".$this->avatar."', `nid`='".$this->nid."', `type`='".$this->type."', `address`='".$this->address."', `latitude`='".$this->latitude."', `longitude`='".$this->longitude."', `phoneno`='".$this->phoneno."', `email`='".$this->email."'";

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
