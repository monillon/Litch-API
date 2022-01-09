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
include_once '../objects/organe.php';
 
$database = new Database();
$db = $database->getConnection();
 
$organe = new Organe($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$nom_organe = isset($_GET["nom_organe"]) ? $_GET["nom_organe"] : "";

// make sure data is not empty
if(!empty($nom_organe))
{
 
    // set sujet property values
    $organe->nom_organe = $nom_organe;
    
    // create the sujet
    if($organe->create($nom_organe)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "organ was created."));
    }
 
    // if unable to create the sujet, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create organ."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create organ. Data is incomplete."));
}

?>