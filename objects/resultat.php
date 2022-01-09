<?php
class Resultat {
	//database connection and table name 
	private $conn; 
	private $table_name = "RESULTAT"; 
	
	//object properties 
	public $id_resultat; 
	public $id_manipulation; 
	public $stockage_resultat_brut; 
	public $date_heure_brut; 
	public $stockage_resultat_analyse; 
	public $date_heure_analyse;
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_manip($id_manip){
	
		//select all query 
		$query = " SELECT res.id_resultat, res.id_manipulation, res.stockage_resultat_brut, 
							res.date_heure_brut, res.stockage_resultat_analyse, res.date_heure_analyse
					FROM " . $this->table_name . " res 
					WHERE res.id_manipulation=? "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt->bindParam(1,$id_manip);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}
}
	
?>