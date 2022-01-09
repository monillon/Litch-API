<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate utilisateur object
include_once '../objects/utilisateur.php';
 
$database = new Database();
$db = $database->getConnection();
 
$utilisateur = new Utilisateur($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$nom_utilisateur = isset($_GET["nom_u"]) ? $_GET["nom_u"] : "";
$mot_de_passe = isset($_GET["mdp_u"]) ? $_GET["mdp_u"] : "";
$id_role = isset($_GET["id_role"]) ? $_GET["id_role"] : "";

// make sure data is not empty
if(
   !empty($nom_utilisateur) &&
   !empty($mot_de_passe) &&
   !empty($id_role))
{
 
    // set utilisateur property values
    $utilisateur->nom_utilisateur = $nom_utilisateur;
    $utilisateur->mot_de_passe = $mot_de_passe;
    $utilisateur->id_role = $id_role;
 
    // create the utilisateur
    if($utilisateur->insert($nom_utilisateur,$mot_de_passe,$id_role)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "utilisateur was created."));
    }
 
    // if unable to create the utilisateur, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create utilisateur."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create utilisateur. Data is incomplete."));
}

?>