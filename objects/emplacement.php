<?php
class Emplacement {
	//database connection and table name 
	private $conn; 
	private $table_name = "EMPLACEMENT"; 
	
	//object properties 
	public $id_emplacement; 
	public $id_prelevement; 
	public $id_etagere; 
	public $coordonnee_x; 
	public $coordonnee_y; 
	public $libre; 
	public $id_boite; 
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}


	function read($id_p){
	
		//select all query 
		$query = "  SELECT emp.id_emplacement, emp.id_prelevement, e.nom_etagere, emp.coordonnee_x, emp.coordonnee_y, emp.libre, emp.id_boite,
							f.nom_frigo, emp.id_etagere, e.id_frigo 
					FROM " . $this->table_name . " emp 
					JOIN ETAGERE e USING(id_etagere)
					JOIN FRIGO f USING(id_frigo)
					WHERE emp.id_prelevement=?"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		$stmt-> bindParam(1,$id_p);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function read_libre($id_etagere,$id_boite,$id_rack){
	
		//select all query 
		$query = " SELECT emp.id_emplacement, emp.id_prelevement, e.nom_etagere, f.nom_frigo,f.id_frigo, e.id_etagere, 
							emp.coordonnee_x, emp.coordonnee_y, emp.libre, emp.id_boite 
					FROM " . $this->table_name . " emp 
					JOIN ETAGERE e USING(id_etagere)
					JOIN FRIGO f USING(id_frigo)
					WHERE emp.libre=1 AND emp.id_etagere =? AND emp.id_boite =? AND emp.id_rack =? "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$id_etagere);
		$stmt-> bindParam(2,$id_boite);
		$stmt-> bindParam(3,$id_rack);

		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}


	function update($id_emplacement,$libre,$id_prelevement){
	
		//select all query 
		$query = " UPDATE ".$this->table_name."
					SET libre = ?,
					id_prelevement = ?
					WHERE id_emplacement = ?"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		$stmt-> bindParam(1,$libre);
		$stmt-> bindParam(2,$id_prelevement);
		$stmt-> bindParam(3,$id_emplacement);
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function insert($id_etagere, $coordonnee_x, $coordonnee_y, $libre, $id_boite, $id_prelevement){
	
		//select all query 
		$query = " INSERT INTO " . $this->table_name . "(id_etagere, id_rack, coordonnee_x, coordonnee_y, libre, id_boite, id_prelevement)
					VALUES(?,?,?,?,?,?) "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$id_etagere);
		$stmt-> bindParam(2,$coordonnee_x);
		$stmt-> bindParam(3,$coordonnee_y);
		$stmt-> bindParam(4,$libre);
		$stmt-> bindParam(5,$id_boite);
		$stmt-> bindParam(6,$id_prelevement);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}


	function read_rack_existant($id_etagere){
	
		//select all query 
		$query = "  SELECT emp.id_rack
					FROM " . $this->table_name . " emp
					WHERE emp.ID_ETAGERE = ?
					GROUP BY emp.ID_RACK"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		// bind
        $stmt->bindParam(1,$id_etagere);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function read_box_existant($id_etagere, $id_rack){
	
		//select all query 
		$query = "  SELECT emp.id_boite
					FROM " . $this->table_name . " emp
					WHERE emp.ID_ETAGERE = ? AND emp.ID_RACK = ?
					GROUP BY emp.ID_BOITE"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		// bind
        $stmt->bindParam(1,$id_etagere);
        $stmt->bindParam(2,$id_rack);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function sample_localisation($id_p){
	
		//select all query 
		$query = "  SELECT emp.id_emplacement, emp.id_boite, emp.id_rack, emp.coordonnee_x, emp.coordonnee_y, et.nom_etagere, f.nom_frigo 
					FROM " . $this->table_name . " emp
					JOIN ETAGERE et using(ID_ETAGERE) 
					JOIN FRIGO f using(ID_FRIGO) 
					WHERE emp.id_prelevement = ?";
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		$stmt-> bindParam(1,$id_p);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function sample_localisation_id($id_p){
	
		//select all query 
		$query = "  SELECT emp.id_emplacement, emp.id_boite
					FROM " . $this->table_name . " emp
					WHERE emp.id_prelevement = ?";
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		$stmt-> bindParam(1,$id_p);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function create_slot($coordonnee_x, $coordonnee_y, $id_boite){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(id_etagere, id_rack, coordonnee_x, coordonnee_y, libre, id_boite)
                VALUES(2,'A',?,?,1,?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        //$stmt->bindParam(1,$id_etagere);
        $stmt->bindParam(1,$coordonnee_x);
        $stmt->bindParam(2,$coordonnee_y);
        $stmt->bindParam(3,$id_boite);
        
        // execute query
        $stmt->execute();
     
        return $stmt;
    }    

	function delete_slot($id_boite){
    
        // select all query
        $query = "DELETE FROM " . $this->table_name . " 
					WHERE id_boite = ?";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$id_boite);
        
        // execute query
        $stmt->execute();
     
        return $stmt;
    }    

	function read_id_prelevement_by_box($id_etagere, $id_boite){
	
		//select all query 
		$query = "  SELECT emp.id_prelevement
					FROM " . $this->table_name . " emp
					WHERE emp.id_prelevement != 'null' AND emp.ID_ETAGERE = ? AND emp.id_boite = ?
					GROUP BY emp.id_prelevement"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		// bind
        $stmt->bindParam(1,$id_etagere);
        $stmt->bindParam(2,$id_boite);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function create_single_slot($id_etagere, $id_rack,$id_prelevement){
	
		//select all query 
		$query = " INSERT INTO " . $this->table_name . "(id_etagere, id_rack, libre, id_prelevement)
					VALUES(?,?,0,?) "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$id_etagere);
		$stmt-> bindParam(2,$id_rack);
		$stmt-> bindParam(3,$id_prelevement);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}


	function box_slot($id_frigo, $id_etagere, $id_rack, $id_boite){
	
		//select all query 
		$query = "  SELECT emp.id_emplacement, emp.id_rack, emp.coordonnee_x, emp.coordonnee_y, emp.libre, emp.id_boite, emp.id_prelevement,
							et.id_etagere, et.nom_etagere,
							f.id_frigo, f.nom_frigo 
					FROM " . $this->table_name . " emp
					JOIN ETAGERE et using(ID_ETAGERE) 
					JOIN FRIGO f using(ID_FRIGO) 
					WHERE f.id_frigo = ? AND emp.id_etagere=? AND emp.id_rack=? AND emp.id_boite=?";
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		$stmt-> bindParam(1,$id_frigo);
		$stmt-> bindParam(2,$id_etagere);
		$stmt-> bindParam(3,$id_rack);
		$stmt-> bindParam(4,$id_boite);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}


	function read_one_location($id_emplacement){
	
		//select all query 
		$query = "  SELECT emp.id_boite, emp.id_rack, emp.coordonnee_x, emp.coordonnee_y, emp.libre, emp.id_prelevement
					FROM " . $this->table_name . " emp
					WHERE emp.id_emplacement = ?";
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		$stmt-> bindParam(1,$id_emplacement);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}


	function read_temporary_box(){
	
		//select all query 
		$query = "  SELECT emp.id_emplacement, emp.id_prelevement, emp.coordonnee_x, emp.coordonnee_y, emp.libre, emp.id_boite
					FROM " . $this->table_name . " emp 
					WHERE emp.id_boite=0"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		$stmt-> bindParam(1,$id_p);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}
      
}
?>