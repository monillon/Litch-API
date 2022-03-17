<?php
class Pathologie {
	//database connection and table name 
	private $conn; 
	private $table_name = "PATHOLOGIE" ; 
	
	//object properties 
	public $id_pathologie;
	public $nom_pathologie;
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read($id_s){
	
		//select all query 
		$query = " SELECT patho.id_pathologie, patho.nom_pathologie 
					FROM " . $this->table_name . " patho 
					JOIN PHENOTYPE q USING(id_pathologie)
					WHERE q.id_sujet=?"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt->bindParam(1, $id_s);

		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function read_all(){
	
		//select all query 
		$query = " SELECT patho.id_pathologie, patho.nom_pathologie 
					FROM " . $this->table_name . " patho "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}


	function create($nom_pathologie){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(nom_pathologie)
                VALUES(?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$nom_pathologie);

        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function delete_patho($id_patho) {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_PATHOLOGIE=?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind
        $stmt->bindParam(1,$id_patho);

        // execute query
        $stmt->execute();

        return $stmt;
    }

}
	
?>