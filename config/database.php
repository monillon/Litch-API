<?php
class Database{

    // specify your own database credentials
    private $host = "db5000548814.hosting-data.io";
    private $db_name = "dbs526813";
    private $username = "dbu647058";
    private $password = "cocwug-2cybwu-kobBys";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = 'null';

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;

    }
}
?> 