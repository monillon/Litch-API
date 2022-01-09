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
include_once '../objects/tissu.php';
 
$database = new Database();
$db = $database->getConnection();
 
$tissu = new Tissu($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$nom_tissu = isset($_GET["nom_tissu"]) ? $_GET["nom_tissu"] : "";

// make sure data is not empty
if(!empty($nom_tissu))
{
 
    // set sujet property values
    $tissu->nom_tissu = $nom_tissu;
    
    // create the sujet
    if($tissu->create($nom_tissu)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "tissue was created."));
    }
 
    // if unable to create the sujet, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create tissue."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create tissue. Data is incomplete."));
}

?>