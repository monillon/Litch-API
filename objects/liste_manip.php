<?php
class ListeManip {
	//database connection and table name 
	private $conn; 
	private $table_name = "LISTE_MANIP" ; 
	
	//object properties 
	public $id_liste_manip; 
	public $id_categorie_manip; 
	public $nom_liste_manip;
	public $description_liste_manip; 
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_all(){
	
		//select all query 
		$query = " SELECT liste.id_liste_manip, liste.id_categorie_manip, 
							liste.nom_liste_manip, liste.description_liste_manip 
					FROM " . $this->table_name . " liste "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}
}
	
?>