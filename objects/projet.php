<?php
class Projet{
 
    // database connection and table name
    private $conn;
    private $table_name = "PROJET";
 
    // object properties
    public $id_projet;
    public $code_projet;
    public $nom_projet;
    public $img_projet;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read($s){
    
        // select all query
        $query = "SELECT
                     p.id_projet, p.code_projet, p.nom_projet, p.img_projet
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        EST_ASSOCIE c
                            ON p.id_projet = c.id_projet
                    WHERE c.id_utilisateur= ?
                ORDER BY
                    p.id_projet DESC";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1, $s);

        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    // read all project
    function readAll(){
    
        // select all query
        $query = "SELECT
                     p.id_projet, p.code_projet, p.nom_projet, p.img_projet
                FROM
                    " . $this->table_name . " p ";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1, $s);

        // execute query
        $stmt->execute();
     
        return $stmt;
    }


    function create($code_projet, $nom_projet, $img_projet){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(code_projet, nom_projet, img_projet)
                VALUES(?,?,?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$code_projet);
        $stmt->bindParam(2,$nom_projet);
        $stmt->bindParam(3,$img_projet);
        
        // execute query
        $stmt->execute();
     
        return $stmt;
    }    
}
?>