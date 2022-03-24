<?php
class DonneesPreop {
	//database connection and table name 
	private $conn; 
	private $table_name = "DONNEES_PREOP"; 
	
	//object properties 
	public $id_preop;
	public $nom_preop;
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read($id_s){
	
		//select all query 
		$query = " SELECT dp.id_preop, dp.nom_preop, q.valeur_preop, u.nom_unite
					FROM " . $this->table_name . " dp 
					JOIN PHENOTYPE q USING(id_preop)
					JOIN UNITE u USING(id_unite)
					WHERE q.id_sujet=? "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		$stmt->bindParam(1, $id_s);

		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function read_all(){
	
		//select all query 
		$query = " SELECT dp.id_preop, dp.nom_preop
					FROM " . $this->table_name . " dp ";
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}


	function create($nom_preop){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(nom_preop)
                VALUES(?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$nom_preop);

        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function delete_preopData($id_preopData) {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_PREOP=?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind
        $stmt->bindParam(1,$id_preopData);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    function read_one($id_preopData){

        //select all query
        $query = "  SELECT * FROM " . $this->table_name . " WHERE ID_PREOP=?";

        //prepare query statement
        $stmt = $this->conn->prepare($query);
        $stmt-> bindParam(1,$id_preopData);

        //execute query
        $stmt->execute();

        return $stmt;

    }


}
	
?>