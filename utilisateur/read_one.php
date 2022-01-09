<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/utilisateur.php';
 
// instantiate database and utilisateur object
$database = new Database();
$db = $database->getConnection();
 
 // get keywords
$nom_u=isset($_GET["a"]) ? $_GET["a"] : "";
$mdp_u=isset($_GET["b"]) ? $_GET["b"] : "";


// initialize object
$utilisateur = new Utilisateur($db);
 
// query utilisateurs
$stmt = $utilisateur->read_one($nom_u,$mdp_u);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // utilisateurs array
    $utilisateurs_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $utilisateur_item=array(
            "ID_UTILISATEUR" => $id_utilisateur,
            "NOM_UTILISATEUR" => $nom_utilisateur,
        );
 
        array_push($utilisateurs_arr, $utilisateur_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show utilisateurs data in json format
    echo json_encode($utilisateurs_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no utilisateurs found
    echo json_encode(
        array("message" => "Aucun utilisateur trouvé.")
    );
}