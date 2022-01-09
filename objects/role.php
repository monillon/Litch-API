<?php
class ROLE {
	//database connection and table name 
	private $conn; 
	private $table_name = "ROLE"; 
	
	//object properties 
	public $id_role; 
	public $nom_role; 

	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_all(){
	
		//select all query 
		$query = " SELECT r.id_role, r.nom_role
					FROM " . $this->table_name . " r "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function read_one($nom_role){
	
		//select all query 
		$query = " SELECT r.id_role, r.nom_role
					FROM " . $this->table_name . " r
					WHERE r.nom_role=?"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$nom_role);

		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

}
	
?>