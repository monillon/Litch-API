<?php
class CategorieManipulation {
	//database connection and table name 
	private $conn; 
	private $table_name = "CATEGORIE_MANIPULATION"; 
	
	//object properties 
	public $id_categorie_manip; 
	public $nom_categorie_manip; 
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_all(){
	
		//select all query 
		$query = " SELECT catego.id_categorie_manip, catego.nom_categorie_manip 
					FROM " . $this->table_name . " catego "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}
}
	
?>