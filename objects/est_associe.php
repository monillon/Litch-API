<?php
class Est_Associe{
    // database connection and table name
    private $conn;
    private $table_name = "EST_ASSOCIE";
 
    // object properties
    public $id_utilisateur;
    public $id_projet;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read projects
      function read(){
     
        // select all query
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " ";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
}
?>