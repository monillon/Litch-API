<?php
class Frigo {
	//database connection and table name 
	private $conn; 
	private $table_name = "FRIGO"; 
	
	//object properties 
	public $id_frigo; 
	public $nom_frigo; 
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_all(){

		//select all query 
		$query = " SELECT f.id_frigo, f.nom_frigo 
					FROM " . $this->table_name . " f "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}
}	
	
?>