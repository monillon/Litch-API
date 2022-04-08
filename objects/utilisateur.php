<?php
class Utilisateur {
	//database connection and table name 
	private $conn; 
	private $table_name = "UTILISATEUR"; 
	
	//object properties 
	public $id_utilisateur; 
	public $nom_utilisateur; 
	public $mot_de_passe; 
	public $id_role;
	public $nom_role;

	//constructor with $db as database connection 
	public function __construct($db){
		$this->conn=$db; 
	}
	//read projects
	function read_all(){
	
		//select all query 
		$query = " SELECT u.id_utilisateur, u.nom_utilisateur, u.mot_de_passe
					FROM " . $this->table_name . " u "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function read_one($nom_u, $mdp_u){
	
		//select all query 
		$query = " SELECT u.id_utilisateur, u.nom_utilisateur, u.mot_de_passe
					FROM " . $this->table_name . " u
					WHERE u.nom_utilisateur=? AND u.mot_de_passe=? "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$nom_u);
		$stmt-> bindParam(2,$mdp_u);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function read_one_with_role($nom_u, $mdp_u){
	
		//select all query 
		$query = " SELECT u.id_utilisateur, u.nom_utilisateur, u.mot_de_passe, r.nom_role
					FROM " . $this->table_name . " u join ROLE r using(id_role)
					WHERE u.nom_utilisateur=? AND u.mot_de_passe=? "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$nom_u);
		$stmt-> bindParam(2,$mdp_u);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function insert($nom_utilisateur, $mot_de_passe, $id_role){
	
		//select all query 
		$query = " INSERT INTO " . $this->table_name . "(nom_utilisateur, mot_de_passe, id_role)
					VALUES(?,?,?) "; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 

		$stmt-> bindParam(1,$nom_utilisateur);
		$stmt-> bindParam(2,$mot_de_passe);
		$stmt-> bindParam(3,$id_role);
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

	function read_with_role(){
	
		//select all query 
		$query = " SELECT u.id_utilisateur, u.nom_utilisateur, u.mot_de_passe, r.nom_role
					FROM " . $this->table_name . " u join ROLE r using(id_role)"; 
					
		//prepare query statement 
		$stmt = $this->conn->prepare($query); 
		
		//execute query
		$stmt->execute(); 
		
		return $stmt; 
		
	}

    function read_one_id($id_user){

        //select all query
        $query = " SELECT u.nom_utilisateur
					FROM " . $this->table_name . " u
					WHERE u.nom_utilisateur=?";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt-> bindParam(1,$id_user);

        //execute query
        $stmt->execute();

        return $stmt;

    }

}
	
?>