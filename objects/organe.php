<?php
class  Organe {
	//database connection and table name 
	private $conn; 
	private $table_name = "ORGANE"; 
	
	//object properties 
	public $id_organe; 
	public $nom_organe; 
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_all(){
	
		//select all query 
		$query = " SELECT org.id_organe, org.nom_organe
					FROM " . $this->table_name . " org 
					ORDER BY org.nom_organe ASC"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}


	function create($nom_organe){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(nom_organe)
                VALUES(?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$nom_organe);

        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function delete_organe($id_organe) {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_ORGANE=?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind
        $stmt->bindParam(1,$id_organe);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function read_one($id_organe){

        //select all query
        $query = "  SELECT * FROM " . $this->table_name . " WHERE ID_ORGANE=?";

        //prepare query statement
        $stmt = $this->conn->prepare($query);
        $stmt-> bindParam(1,$id_organe);

        //execute query
        $stmt->execute();

        return $stmt;

    }



}
	
?>