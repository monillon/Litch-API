<?php
class Mutation {
	//database connection and table name 
	private $conn; 
	private $table_name = "MUTATION" ; 
	
	//object properties 
	public $id_mutation;
	public $id_pathologie;
	public $nom_mutation;
	public $classe;
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read($id_s){
	
		//select all query 
		$query = " SELECT muta.id_mutation, muta.id_pathologie, muta.nom_mutation, muta.classe 
					FROM " . $this->table_name . " muta 
					JOIN PHENOTYPE q USING(id_mutation)
					WHERE q.id_sujet=? ;"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$id_s);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function read_all(){
	
		//select all query 
		$query = " SELECT muta.id_mutation, muta.id_pathologie, muta.nom_mutation, muta.classe 
					FROM " . $this->table_name . " muta"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

		function read_patho($id_p){
	
		//select all query 
		$query = " SELECT muta.id_mutation, muta.id_pathologie, muta.nom_mutation, muta.classe 
					FROM " . $this->table_name . " muta 
					WHERE muta.id_pathologie=? ;"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$id_p);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}


	function create($id_pathologie,$nom_mutation){
    
        // select all query
        $query = "INSERT INTO " . $this->table_name . "(id_pathologie,nom_mutation)
                VALUES(?,?)";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind
        $stmt->bindParam(1,$id_pathologie);
        $stmt->bindParam(2,$nom_mutation);
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function read_one($id_mutation){

        //select all query
        $query = "  SELECT * FROM " . $this->table_name . " WHERE ID_MUTATION=?";

        //prepare query statement
        $stmt = $this->conn->prepare($query);
        $stmt-> bindParam(1,$id_mutation);

        //execute query
        $stmt->execute();

        return $stmt;

    }
    function delete($id_mutation) {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_MUTATION=?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind
        $stmt->bindParam(1,$id_mutation);

        // execute query
        $stmt->execute();

        return $stmt;
    }



}
?>