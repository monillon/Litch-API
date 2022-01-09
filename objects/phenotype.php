<?php
class Phenotype {
    //database connection and table name 
    private $conn; 
    private $table_name = "PHENOTYPE"; 
    
    //object properties 
    public $id_phenotype;
    public $id_unite;
    public $id_preop;
    public $id_sujet;
    public $id_pathologie;
    public $id_prescription;
    public $id_mutation;
    public $valeur_preop;
    
    //constructor with $db as database connection 
    public function __construct($db){
        $this->conn=$db; 
    }
    //read projects
    function read($id_s){
    
        //select all query 
        $query = " SELECT pheno.id_phenotype, pheno.id_mutation, pheno.valeur_preop, pheno.id_preop,
                            dp.nom_preop, 
                            u.nom_unite, 
                            p.id_pathologie, p.nom_pathologie,
                            m.id_mutation, m.nom_mutation, m.classe,
                            pre.id_prescription, pre.nom_prescription
                    FROM " . $this->table_name . " pheno 
                    JOIN DONNEES_PREOP dp USING(id_preop)
                    JOIN UNITE u USING(id_unite)
                    JOIN PATHOLOGIE p USING(id_pathologie)
                    JOIN MUTATION m USING(id_mutation)
                    JOIN PRESCRIPTION pre USING(id_prescription)
                    WHERE pheno.id_sujet=?"; 
                    
        //prepare query statement 
        $stmt = $this->conn->prepare($query); 
        
        $stmt->bindParam(1, $id_s);

        //execute query
        $stmt->execute(); 
        
        return $stmt; 
        
    }

    function create($id_sujet,$id_pathologie,$id_prescription,$id_mutation){
    
      // select all query
        $query = "INSERT INTO " . $this->table_name . "(id_sujet,id_pathologie,id_prescription,id_mutation)
                VALUES(?,?,?,?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$id_sujet);
        $stmt->bindParam(2,$id_pathologie);
        $stmt->bindParam(3,$id_prescription);
        $stmt->bindParam(4,$id_mutation);
       
        // execute query
        $stmt->execute();
     
        return $stmt;
    }    

    function create_preop($id_sujet,$id_unite,$id_preop,$valeur_preop){
    
      // select all query
        $query = "INSERT INTO " . $this->table_name . "(id_sujet,id_unite,id_preop,valeur_preop)
                VALUES(?,?,?,?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$id_sujet);
        $stmt->bindParam(2,$id_unite);
        $stmt->bindParam(3,$id_preop);
        $stmt->bindParam(4,$valeur_preop);
       
        // execute query
        $stmt->execute();
     
        return $stmt;
    } 


    function create_pheno_preop($id_unite,$id_preop,$id_sujet,$id_pathologie,$id_prescription,$id_mutation,$valeur_preop){
        
          // select all query
            $query = "INSERT INTO " . $this->table_name . "(id_unite,id_preop,id_sujet,id_pathologie,id_prescription,id_mutation,valeur_preop)
                    VALUES(?,?,?,?,?,?,?)";
         
            // prepare query statement
            $stmt = $this->conn->prepare($query);
            
            // bind
            $stmt->bindParam(1,$id_unite);
            $stmt->bindParam(2,$id_preop);
            $stmt->bindParam(3,$id_sujet);
            $stmt->bindParam(4,$id_pathologie);
            $stmt->bindParam(5,$id_prescription);
            $stmt->bindParam(6,$id_mutation);
            $stmt->bindParam(7,$valeur_preop);
            // execute query
            $stmt->execute();
         
            return $stmt;
        } 


    function create_pheno_no_patho($id_unite,$id_preop,$id_sujet,$valeur_preop){
        
          // select all query
            $query = "INSERT INTO " . $this->table_name . "(id_unite,id_preop,id_sujet,valeur_preop)
                    VALUES(?,?,?,?)";
         
            // prepare query statement
            $stmt = $this->conn->prepare($query);
            
            // bind
            $stmt->bindParam(1,$id_unite);
            $stmt->bindParam(2,$id_preop);
            $stmt->bindParam(3,$id_sujet);
            $stmt->bindParam(4,$valeur_preop);
            // execute query
            $stmt->execute();
         
            return $stmt;
        } 


}
    
?>