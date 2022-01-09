<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate protocole object
include_once '../objects/protocole.php';
 
$database = new Database();
$db = $database->getConnection();
 
$protocole = new Protocole($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$nom_protocole = isset($_GET["nom_protocole"]) ? $_GET["nom_protocole"] : "";


// make sure data is not empty
if(
   !empty($nom_protocole)
)
{
 
    // set protocole property values
    $protocole->nom_protocole = $nom_protocole;
    
 
    // create the protocole
    if($protocole->create($nom_protocole)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "protocole was created."));
    }
 
    // if unable to create the protocole, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create protocole."));
    }
}

// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create protocole. Data is incomplete."));
}

?>