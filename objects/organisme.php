<?php
class Organisme{
	//database connection and table name 
	private $conn; 
	private $table_name = "ORGANISME"; 
	
	//object properties 
	public $id_organisme; 
	public $nom_organisme; 
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_all(){
	
		//select all query 
		$query = " SELECT o.id_organisme, o.nom_organisme
					FROM " . $this->table_name . " o "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}
}		
?>