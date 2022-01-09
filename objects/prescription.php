<?php
class Prescription {
	//database connection and table name 
	private $conn; 
	private $table_name = "PRESCRIPTION"; 
	
	//object properties 
	public $id_prescription;
	public $nom_prescription;
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read($id_s){
	
		//select all query 
		$query = " SELECT prescri.id_prescription, prescri.nom_prescription 
					FROM " . $this->table_name . " prescri 
					JOIN PHENOTYPE q USING(id_prescription)
					WHERE q.id_sujet= ?"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$id_s);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}
	function read_all(){
	
		//select all query 
		$query = " SELECT prescri.id_prescription, prescri.nom_prescription 
					FROM " . $this->table_name . " prescri ";


		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}


	function create($nom_prescription){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(nom_prescription)
                VALUES(?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$nom_prescription);

        // execute query
        $stmt->execute();
     
        return $stmt;
    }  

}
	
?>