<?php
class Tissu {
	//database connection and table name 
	private $conn; 
	private $table_name = "TISSU"; 
	
	//object properties 
	public $id_tissu; 
	public $nom_tissu; 
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_all(){
	
		//select all query 
		$query = " SELECT t.id_tissu, t.nom_tissu
					FROM " . $this->table_name . " t "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function create($nom_tissu){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(nom_tissu)
                VALUES(?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$nom_tissu);

        // execute query
        $stmt->execute();
     
        return $stmt;
    }


    function delete_tissu($id_tissu) {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_TISSU=?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind
        $stmt->bindParam(1,$id_tissu);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}


