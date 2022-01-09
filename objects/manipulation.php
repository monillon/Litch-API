<?php
class Manipulation {
	//database connection and table name 
	private $conn; 
	private $table_name = "MANIPULATION"; 
	
	//object properties 
	public $id_manipulation;
	public $id_utilisateur;
	public $id_modele_manip;
	public $id_prelevement;
	public $id_resultat;
	public $date_heure_manipulation;
	public $commentaire_manipulation;

	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_prelevement($id_p){
	
		//select all query 
		$query = " SELECT manip.id_manipulation, manip.id_prelevement, manip.date_heure_manipulation, manip.commentaire_manipulation,
						u.nom_utilisateur, m.nom_modele_manip
					FROM " . $this->table_name . " manip 
					JOIN UTILISATEUR u USING(id_utilisateur)
					JOIN MODELE_MANIP m USING(id_modele_manip)
					WHERE manip.id_prelevement= ?"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$id_p);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function read_grp($id_grp){
	
		//select all query 
		$query = " SELECT manip.id_manipulation, manip.id_prelevement, manip.date_heure_manipulation, manip.commentaire_manipulation,
						u.nom_utilisateur, s.code_sujet, m.nom_modele_manip, o.nom_organe
					FROM " . $this->table_name . " manip 
					JOIN UTILISATEUR u USING(id_utilisateur)
					JOIN MODELE_MANIP m USING(id_modele_manip)
					JOIN PRELEVEMENT p USING(id_prelevement)
					JOIN ORGANE o USING(id_organe)
					JOIN SUJET s USING(id_sujet)
					WHERE s.id_grp= ?";
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$id_grp);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function read_grp_count($id_grp){
	
		//select all query 
		$query = " SELECT Count(manip.id_manipulation) as nb_manip
					FROM " . $this->table_name . " manip 
					JOIN UTILISATEUR u USING(id_utilisateur)
					JOIN MODELE_MANIP m USING(id_modele_manip)
					JOIN PRELEVEMENT p USING(id_prelevement)
					JOIN ORGANE o USING(id_organe)
					JOIN SUJET s USING(id_sujet)
					WHERE s.id_grp= ?";
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$id_grp);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function read_manip($id_manip){
	
		//select all query 
		$query = " SELECT manip.id_manipulation, manip.id_prelevement, manip.date_heure_manipulation, manip.commentaire_manipulation,
						u.nom_utilisateur, s.code_sujet, m.nom_modele_manip, o.nom_organe, s.id_sujet, s.sexe_sujet, s.age_sujet, s.uni_id_unite
					FROM " . $this->table_name . " manip 
					JOIN UTILISATEUR u USING(id_utilisateur)
					JOIN MODELE_MANIP m USING(id_modele_manip)
					JOIN PRELEVEMENT p USING(id_prelevement)
					JOIN ORGANE o USING(id_organe)
					JOIN SUJET s USING(id_sujet)
					WHERE manip.id_manipulation= ?";
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$id_manip);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

    function create($id_utilisateur,$id_modele_manip,$id_prelevement,$date_heure_manipulation,$commentaire_manipulation){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(id_utilisateur,id_modele_manip,id_prelevement,date_heure_manipulation,commentaire_manipulation)
                VALUES(?,?,?,?,?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$id_utilisateur);
        $stmt->bindParam(2,$id_modele_manip);
        $stmt->bindParam(3,$id_prelevement);
        $stmt->bindParam(4,$date_heure_manipulation);
        $stmt->bindParam(5,$commentaire_manipulation);
        
        // execute query
        $stmt->execute();
     
        return $stmt;
    }   

	function delete_manip($id_prelevement){
    
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
	

	function read_search($id_projet,$search){
	
		//select all query 
		$query ="SELECT s.CODE_SUJET, u.NOM_UTILISATEUR, m.DATE_HEURE_MANIPULATION, m.COMMENTAIRE_MANIPULATION,
				(SELECT NOM_ORGANE FROM ORGANE WHERE ID_ORGANE like pre.ID_ORGANE) as NOM_ORGANE,
				(SELECT NOM_TISSU FROM TISSU WHERE ID_TISSU like pre.ID_TISSU) as NOM_TISSU
				FROM " . $this->table_name . " m JOIN PRELEVEMENT pre USING(ID_PRELEVEMENT) JOIN SUJET s USING(ID_SUJET) JOIN GROUPE g USING(ID_GRP) JOIN MODELE_MANIP mm USING(ID_MODELE_MANIP) JOIN UTILISATEUR u USING(ID_UTILISATEUR)
				WHERE g.ID_PROJET like ? AND (upper(m.COMMENTAIRE_MANIPULATION) like ? or upper(u.NOM_UTILISATEUR) like ? or upper(s.CODE_SUJET) like ? or 
				                             pre.ID_ORGANE like (SELECT ID_ORGANE FROM ORGANE WHERE upper(NOM_ORGANE) like ?) or
				                             pre.ID_TISSU like (SELECT ID_TISSU FROM TISSU WHERE upper(NOM_TISSU) like ?))";
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$id_projet);
		$stmt-> bindParam(2,$search);
		$stmt-> bindParam(3,$search);
		$stmt-> bindParam(4,$search);
		$stmt-> bindParam(5,$search);
		$stmt-> bindParam(6,$search);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function update($commentaire_manipulation,$id_manipulation){
	
		//select all query 
		$query = " UPDATE ".$this->table_name."
					SET commentaire_manipulation = ?
					WHERE id_manipulation = ?"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		$stmt-> bindParam(1,$commentaire_manipulation);
		$stmt-> bindParam(2,$id_manipulation);
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}
	
}
	
?>