<?php
class  Unite {
	//database connection and table name 
	private $conn; 
	private $table_name = "UNITE" ; 
	
	//object properties 
	public $id_unite;
	public $nom_unite;
	public $description_unite;
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_all(){
	
		//select all query 
		$query = " SELECT unit.id_unite, unit.nom_unite, unit.description_unite
					FROM " . $this->table_name . " unit "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 	
	}


	function create($nom_unite,$description_unite){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(nom_unite,description_unite)
                VALUES(?,?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$nom_unite);
		$stmt->bindParam(2,$description_unite);
        // execute query
        $stmt->execute();
     
        return $stmt;
    }


    function read_one($id_unite){
	
		//select all query 
		$query = " SELECT unit.nom_unite, unit.description_unite
					FROM " . $this->table_name . " unit 
					WHERE unit.id_unite = ?"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		$stmt->bindParam(1, $id_unite);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 	
	}
}
?>