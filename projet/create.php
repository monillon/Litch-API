<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate projet object
include_once '../objects/projet.php';
 
$database = new Database();
$db = $database->getConnection();
 
$projet = new Projet($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$code_projet = isset($_GET["code_projet"]) ? $_GET["code_projet"] : "";
$nom_projet = isset($_GET["nom_projet"]) ? $_GET["nom_projet"] : "";
$img_projet = $_GET["img_projet"];

// make sure data is not empty
if(
   !empty($code_projet) &&
   !empty($nom_projet))
{
 
    // set projet property values
    $projet->code_projet = $code_projet;
    $projet->nom_projet = $nom_projet;
    $projet->img_projet = $img_projet;
 
    // create the projet
    if($projet->create($code_projet,$nom_projet,$img_projet)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "projet was created."));
    }
 
    // if unable to create the projet, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create projet."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create projet. Data is incomplete."));
}

?>