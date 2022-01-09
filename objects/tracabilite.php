<?php
class Tracabilite {
	//database connection and table name 
	private $conn; 
	private $table_name = "TRACABILITE"; 
	
	//object properties 
	public $id_trace; 
	public $id_utilisateur;
	public $date;
	public $action;
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}


	function read_all(){
	
		//select all query 
		$query = " SELECT t.id_trace, t.id_utilisateur, t.date, t.action
					FROM " . $this->table_name . " t "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function create($id_utilisateur, $date, $action){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(id_utilisateur, date, action)
                VALUES(?, ?, ?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$id_utilisateur);
        $stmt->bindParam(2,$date);
        $stmt->bindParam(3,$action);

        // execute query
        $stmt->execute();
     
        return $stmt;
    }  
}
	
?>