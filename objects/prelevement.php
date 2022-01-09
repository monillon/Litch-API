<?php
class Prelevement {
	//database connection and table name 
	private $conn; 
	private $table_name = "PRELEVEMENT"; 
	
	//object properties 
	public $id_prelevement; 
	public $id_tissu; 
	public $id_organe; 
	public $id_sujet;
	public $date_heure_prelevement; 
	public $commentaire_prelevement; 
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}

	function read_sujet($id_s){
	
		//select all query 
		$query = " SELECT pre.id_prelevement, pre.id_tissu, pre.id_organe,
							pre.id_sujet, pre.date_heure_prelevement, 
							pre.commentaire_prelevement, o.nom_organe, t.nom_tissu
					FROM " . $this->table_name . " pre 
					JOIN ORGANE o USING(id_organe)
					JOIN TISSU t USING(id_tissu)
					WHERE pre.id_sujet=? "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		$stmt-> bindParam(1,$id_s);

		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function read_groupe($id_grp){
	
		//select all query 
		$query = " SELECT pre.id_prelevement, pre.id_tissu, pre.id_organe,
							pre.id_sujet, pre.date_heure_prelevement, 
							pre.commentaire_prelevement, o.nom_organe, t.nom_tissu
					FROM " . $this->table_name . " pre 
					JOIN ORGANE o USING(id_organe)
					JOIN TISSU t USING(id_tissu)
					JOIN SUJET s USING(id_sujet)
					WHERE s.id_grp=? "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$id_grp);

		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

    function create($id_sujet,$date_heure_prelevement,$id_organe,$id_tissu,$commentaire_prelevement){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(id_sujet, date_heure_prelevement, id_organe, id_tissu ,commentaire_prelevement)
                VALUES(?,?,?,?,?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$id_sujet);
        $stmt->bindParam(2,$date_heure_prelevement);
        $stmt->bindParam(3,$id_organe);
        $stmt->bindParam(4,$id_tissu);
        $stmt->bindParam(5,$commentaire_prelevement);


        
        // execute query
        $stmt->execute();
     
        return $stmt;
    }   
    
	function delete_prelev($id_prelevement){
    
        // select all query
        $query = "DELETE FROM " . $this->table_name . " 
					WHERE id_prelevement=?";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$id_prelevement);
        
        // execute query
        $stmt->execute();
     
        return $stmt;
    }    


    function read_search($id_projet, $search){
	
		//select all query 
		$query = " SELECT pre.date_heure_prelevement, pre.commentaire_prelevement, o.nom_organe, t.nom_tissu, s.code_sujet,
					(SELECT emp.id_rack FROM EMPLACEMENT emp WHERE ID_PRELEVEMENT like pre.ID_PRELEVEMENT) as id_rack,
					(SELECT emp.coordonnee_x FROM EMPLACEMENT emp WHERE ID_PRELEVEMENT like pre.ID_PRELEVEMENT) as coordonnee_x,
					(SELECT emp.coordonnee_y FROM EMPLACEMENT emp WHERE ID_PRELEVEMENT like pre.ID_PRELEVEMENT) as coordonnee_y,
					(SELECT emp.ID_BOITE FROM EMPLACEMENT emp WHERE ID_PRELEVEMENT like pre.ID_PRELEVEMENT) as id_boite,
					(SELECT e.NOM_ETAGERE FROM EMPLACEMENT emp JOIN ETAGERE e USING(ID_ETAGERE) WHERE ID_PRELEVEMENT like pre.ID_PRELEVEMENT) as nom_etagere,
					(SELECT f.NOM_FRIGO FROM EMPLACEMENT emp JOIN ETAGERE e USING(ID_ETAGERE) JOIN FRIGO f USING(ID_FRIGO) WHERE ID_PRELEVEMENT like pre.ID_PRELEVEMENT) as nom_frigo
					FROM " . $this->table_name . " pre 
					JOIN ORGANE o USING(id_organe)
					JOIN TISSU t USING(id_tissu)
					JOIN SUJET s USING(id_sujet)
					JOIN GROUPE g USING(id_grp) 
                    JOIN PROJET p USING(id_projet)
					WHERE p.id_projet= ? and (upper(pre.commentaire_prelevement) like ? or upper(s.code_sujet) like ? or upper(o.NOM_ORGANE) like ? or upper(t.NOM_TISSU) like ?)"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$id_projet);
		$stmt-> bindParam(2,$search);
		$stmt-> bindParam(3,$search);
		$stmt-> bindParam(4,$search);
		$stmt-> bindParam(5,$search);

		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}


	function read_sample($id_p){
	
		//select all query 
		$query = " SELECT pre.date_heure_prelevement, 
							o.nom_organe, 
							t.nom_tissu,
							s.code_sujet
					FROM " . $this->table_name . " pre 
					JOIN ORGANE o USING(id_organe)
					JOIN TISSU t USING(id_tissu)
					JOIN SUJET s USING(id_sujet)
					WHERE pre.id_prelevement=? "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		$stmt-> bindParam(1,$id_p);

		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

}

?>