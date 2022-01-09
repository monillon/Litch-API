<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate modele_manip object
include_once '../objects/modele_manip.php';
 
$database = new Database();
$db = $database->getConnection();
 
$modele_manip = new ModeleManip($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$nom_modele_manip = isset($_GET["nom_modele_manip"]) ? $_GET["nom_modele_manip"] : "";
$id_technique = isset($_GET["id_technique"]) ? $_GET["id_technique"] : "";
$id_protocole = isset($_GET["id_protocole"]) ? $_GET["id_protocole"] : "";


// make sure data is not empty
if(
   !empty($nom_modele_manip) &&
   !empty($id_technique)&&
   !empty($id_protocole))
{
 
    // set sujet property values
    $modele_manip->nom_modele_manip = $nom_modele_manip;
    $modele_manip->id_technique = $id_technique;
    $modele_manip->id_protocole = $id_protocole;
 
    // create the sujet
    if($modele_manip->create($nom_modele_manip,$id_technique,$id_protocole)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "the manipulation modele was created." ));
    }
 
    // if unable to create the sujet, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create manipulation modele."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create manipulation modele. Data is incomplete."));
}

?>