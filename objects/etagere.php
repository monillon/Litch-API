<?php
class Etagere {
	//database connection and table name 
	private $conn; 
	private $table_name = "ETAGERE"; 
	
	//object properties 
	public $id_etagere; 
	public $id_frigo; 
	public $nom_etagere;
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read etageres
	function read_all(){
	
		//select all query 
		$query = " SELECT e.id_etagere, e.id_frigo, e.nom_etagere 
					FROM " . $this->table_name . " e "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}


	function read_by_fridge($id_frigo){
	
		//select all query 
		$query = " SELECT e.id_etagere, e.nom_etagere 
					FROM " . $this->table_name . " e 
					WHERE id_frigo=?"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt->bindParam(1, $id_frigo);

		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}
}
	
?>