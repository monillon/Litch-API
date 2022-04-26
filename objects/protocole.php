<?php
class Protocole {
	//database connection and table name 
	private $conn; 
	private $table_name = "PROTOCOLE"; 
	
	//object properties 
	public $id_protocole; 
	public $pro_id_protocole; 
	public $nom_protocole; 
	public $stockage_protocole; 
	public $version_protocole; 
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_all(){
	
		//select all query 
		$query = " SELECT proto.id_protocole, proto.pro_id_protocole, proto.nom_protocole, 
							proto.stockage_protocole, proto.version_protocole 
					FROM " . $this->table_name . " proto "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
	}

	function create($nom_protocole){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(nom_protocole)
                VALUES(?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$nom_protocole);

        // execute query
        $stmt->execute();
     
        return $stmt;
	}

    function read_one($id_protoc){

        //select all query
        $query = "  SELECT ID_PROTOCOLE, NOM_PROTOCOLE FROM " . $this->table_name . " WHERE ID_PROTOCOLE=?";

        //prepare query statement
        $stmt = $this->conn->prepare($query);
        $stmt-> bindParam(1,$id_protoc);

        //execute query
        $stmt->execute();

        return $stmt;

    }

    function delete($id_protoc) {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_PROTOCOLE=?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind
        $stmt->bindParam(1,$id_protoc);

        // execute query
        $stmt->execute();

        return $stmt;
    }


}	
?>