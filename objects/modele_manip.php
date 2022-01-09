<?php
class ModeleManip {
	//database connection and table name 
	private $conn; 
	private $table_name = "MODELE_MANIP" ; 
	
	//object properties 
	public $id_modele_manip; 
	public $id_protocole; 
	public $id_liste_manip; 
	public $id_technique; 
	public $nom_modele_manip; 
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_all(){
	
		//select all query 
		$query = " SELECT mo.id_modele_manip, mo.id_protocole, mo.id_liste_manip,
							mo.id_technique, mo.nom_modele_manip 
					FROM " . $this->table_name . " mo "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}


	function create($nom_modele_manip,$id_technique,$id_protocole){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(id_protocole,id_technique,nom_modele_manip)
                VALUES(?,?,?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$id_protocole);
		$stmt->bindParam(2,$id_technique);
		$stmt->bindParam(3,$nom_modele_manip);
        // execute query
        $stmt->execute();
     
        return $stmt;
	}
	

}	
?>