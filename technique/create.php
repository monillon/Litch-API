<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate technique object
include_once '../objects/technique.php';
 
$database = new Database();
$db = $database->getConnection();
 
$technique = new Technique($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$nom_technique = isset($_GET["nom_technique"]) ? $_GET["nom_technique"] : "";
$description_technique = isset($_GET["description_technique"]) ? $_GET["description_technique"] : "";


// make sure technique is not empty
if(
   !empty($nom_technique)
)
{
 
    // set technique property values
    $technique->nom_technique = $nom_technique;
    
 
    // create the technique
    if($technique->create($nom_technique, $description_technique)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "technique was created."));
    }
 
    // if unable to create the technique, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create technique."));
    }
}

// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create technique. Data is incomplete."));
}

?>