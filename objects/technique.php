<?php
class Technique {
	//database connection and table name 
	private $conn; 
	private $table_name = "TECHNIQUE"; 
	
	//object properties 
	public $id_technique; 
	public $nom_technique; 
	public $description_technique; 
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_all(){
	
		//select all query 
		$query = " SELECT tech.id_technique, tech.nom_technique, tech.description_technique 
					FROM " . $this->table_name . " tech "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function create($nom_technique, $description_technique){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(NOM_TECHNIQUE, DESCRIPTION_TECHNIQUE)
                VALUES(?, ?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$nom_technique);
        $stmt->bindParam(2,$description_technique);

        // execute query
        $stmt->execute();
     
        return $stmt;
	}

    function delete($id_technique) {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_TECHNIQUE=?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind
        $stmt->bindParam(1,$id_technique);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function read_one($id_technique){

        //select all query
        $query = "  SELECT * FROM " . $this->table_name . " WHERE ID_TECHNIQUE=?";

        //prepare query statement
        $stmt = $this->conn->prepare($query);
        $stmt-> bindParam(1,$id_technique);

        //execute query
        $stmt->execute();

        return $stmt;

    }


}	
?>