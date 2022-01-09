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
include_once '../objects/pathologie.php';
 
$database = new Database();
$db = $database->getConnection();
 
$pathologie = new Pathologie($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$nom_pathologie = isset($_GET["nom_pathologie"]) ? $_GET["nom_pathologie"] : "";

// make sure data is not empty
if(!empty($nom_pathologie))
{
 
    // set sujet property values
    $pathologie->nom_pathologie = $nom_pathologie;
    
    // create the sujet
    if($pathologie->create($nom_pathologie)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Pathology was created."));
    }
 
    // if unable to create the sujet, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create Pathology."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create Pathology. Data is incomplete."));
}

?>