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
include_once '../objects/prescription.php';
 
$database = new Database();
$db = $database->getConnection();
 
$prescription = new Prescription($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$nom_prescription = isset($_GET["nom_prescription"]) ? $_GET["nom_prescription"] : "";

// make sure data is not empty
if(!empty($nom_prescription))
{
 
    // set sujet property values
    $prescription->nom_prescription = $nom_prescription;

    // create the sujet
    if($prescription->create($nom_prescription)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Prescription was created."));
    }
 
    // if unable to create the sujet, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create Prescription."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create Prescription. Data is incomplete."));
}

?>