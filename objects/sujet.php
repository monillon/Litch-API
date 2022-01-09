<?php
class Sujet{
    // database connection and table name
    private $conn;
    private $table_name = "SUJET";
 
    // object properties
    public $id_sujet;
    public $id_grp;
    public $id_unite;
    public $uni_id_unite;
    public $code_sujet;
    public $age_sujet;
    public $sexe_sujet;
    public $poids_sujet;
    public $commentaire_sujet;



    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read projects
      function read($s){
     
        // select all query
        $query = "SELECT
                    s.id_sujet, s.id_grp, s.id_unite, s.uni_id_unite, s.code_sujet, s.age_sujet, s.sexe_sujet, s.poids_sujet, s.commentaire_sujet
                FROM
                    " . $this->table_name . " s 
                WHERE s.id_grp=?";


     
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $s);

     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function create($code_sujet,$id_grp,$age_sujet,$sexe_sujet,$poids_sujet,$commentaire_sujet,$uni_id_unite,$id_unite){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(code_sujet,id_grp,age_sujet,sexe_sujet,poids_sujet,commentaire_sujet,uni_id_unite,id_unite)
                VALUES(?,?,?,?,?,?,?,?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$code_sujet);
        $stmt->bindParam(2,$id_grp);
        $stmt->bindParam(3,$age_sujet);
        $stmt->bindParam(4,$sexe_sujet);
        $stmt->bindParam(5,$poids_sujet);
        $stmt->bindParam(6,$commentaire_sujet);
        $stmt->bindParam(7,$uni_id_unite);
        $stmt->bindParam(8,$id_unite);

        
        // execute query
        $stmt->execute();
     
        return $stmt;
    }    

        function create_cell($code_sujet,$id_grp,$age_sujet,$commentaire_sujet,$uni_id_unite){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(code_sujet,id_grp,age_sujet,sexe_sujet,poids_sujet,commentaire_sujet,uni_id_unite,id_unite)
                VALUES(?,?,?,0,1,?,?,1)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$code_sujet);
        $stmt->bindParam(2,$id_grp);
        $stmt->bindParam(3,$age_sujet);
        $stmt->bindParam(4,$commentaire_sujet);
        $stmt->bindParam(5,$uni_id_unite);


        
        // execute query
        $stmt->execute();
     
        return $stmt;
    }   



    function read_search($id_projet, $search){
     
        // select all query
        $query = "SELECT
                    s.id_grp, s.code_sujet, s.age_sujet, s.sexe_sujet, s.poids_sujet, s.commentaire_sujet,
                    (SELECT p.NOM_PATHOLOGIE FROM PATHOLOGIE p join PHENOTYPE ph USING(ID_PATHOLOGIE) WHERE ph.ID_SUJET = s.ID_SUJET GROUP BY p.NOM_PATHOLOGIE) as nom_patho,
                    (SELECT u.NOM_UNITE FROM UNITE u WHERE u.ID_UNITE = s.id_unite) as unite_poids,
                    (SELECT u.NOM_UNITE FROM UNITE u WHERE u.ID_UNITE = s.uni_id_unite) as unite_age,
                    (SELECT o.NOM_ORGANISME FROM ORGANISME o join GROUPE g USING (ID_ORGANISME) WHERE g.ID_GRP = s.ID_GRP) as organisme
                FROM
                    " . $this->table_name . " s 
                    join GROUPE g using (id_grp) 
                    join PROJET p using (id_projet)
                WHERE p.id_projet = ? and (upper(s.code_sujet) like ? or s.age_sujet like ? or s.sexe_sujet like ? or s.poids_sujet like ? or upper(s.commentaire_sujet) like ? 
                or g.ID_ORGANISME like (SELECT ID_ORGANISME FROM ORGANISME WHERE upper(NOM_ORGANISME) like ?))";


     
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $id_projet);
        $stmt->bindParam(2, $search);
        $stmt->bindParam(3, $search);
        $stmt->bindParam(4, $search);
        $stmt->bindParam(5, $search);
        $stmt->bindParam(6, $search);
        $stmt->bindParam(7, $search);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
}
?>