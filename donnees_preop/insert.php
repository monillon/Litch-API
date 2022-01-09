<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate sujet object
include_once '../objects/donnees_preop.php';
 
$database = new Database();
$db = $database->getConnection();
 
$donnees_preop = new DonneesPreop($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$nom_preop = isset($_GET["nom_preop"]) ? $_GET["nom_preop"] : "";

// make sure data is not empty
if(!empty($nom_preop))
{
 
    // set sujet property values
    $donnees_preop->nom_preop = $nom_preop;
    
    // create the sujet
    if($donnees_preop->create($nom_preop)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Preop Data was created."));
    }
 
    // if unable to create the sujet, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create Preop Data."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create Preop Data. Data is incomplete."));
}

?>