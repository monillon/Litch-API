<?php
class Groupe{
    // database connection and table name
    private $conn;
    private $table_name = "GROUPE";
 
    // object properties
    public $id_grp;
    public $id_organisme;
    public $id_projet;
    public $code_grp;
    public $nom_grp;
    public $grp_patho;
    public $grp_traite;
    public $nb_membre;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read projects
      function read($id_projet, $id_organisme){
     
        // select all query
        $query = "SELECT
                    g.id_grp, g.id_organisme, g.id_projet, g.code_grp, g.nom_grp, g.grp_patho, g.grp_traite, g.nb_membre
                FROM
                    " . $this->table_name . " g 
                WHERE g.id_projet=? AND g.id_organisme=?";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $id_projet);
        $stmt->bindParam(2, $id_organisme);

     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }


        function create($id_organisme,$id_projet,$code_grp,$nom_grp,$grp_patho,$grp_traite){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(id_organisme,id_projet,code_grp,nom_grp,grp_patho,grp_traite,nb_membre)
                VALUES(?,?,?,?,?,?,0)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$id_organisme);
        $stmt->bindParam(2,$id_projet);
        $stmt->bindParam(3,$code_grp);
        $stmt->bindParam(4,$nom_grp);
        $stmt->bindParam(5,$grp_patho);
        $stmt->bindParam(6,$grp_traite);
        // execute query
        $stmt->execute();
     
        return $stmt;
    }  
}
?>