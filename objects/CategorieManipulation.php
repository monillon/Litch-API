<?php
class CategorieManipulation {
	//database connection and table name 
	private $conn; 
	private $table_name = "CATEGORIE_MANIPULATION"; 
	
	//object properties 
	public $id_categorie_manip; 
	public $nom_categorie_manip; 
	
	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_all(){
	
		//select all query 
		$query = " SELECT catego.id_categorie_manip, catego.nom_categorie_manip 
					FROM " . $this->table_name . " catego "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

    function create($nom_catManip){

        // select all query
        $query = "INSERT INTO " . $this->table_name . "(NOM_CATEGORIE_MANIP)
                VALUES(?)";


        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind
        $stmt->bindParam(1,$nom_catManip);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function read_one($id_catManip){

        //select all query
        $query = "  SELECT * FROM " . $this->table_name . " WHERE ID_CATEGORIE_MANIP=?";

        //prepare query statement
        $stmt = $this->conn->prepare($query);
        $stmt-> bindParam(1,$id_catManip);

        //execute query
        $stmt->execute();

        return $stmt;

    }

    function delete($id_catManip) {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID_CATEGORIE_MANIP=?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind
        $stmt->bindParam(1,$id_catManip);

        // execute query
        $stmt->execute();

        return $stmt;
    }


}
	
?>