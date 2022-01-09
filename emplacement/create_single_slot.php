<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate emplacement object
include_once '../objects/emplacement.php';
 
$database = new Database();
$db = $database->getConnection();
 
$emplacement = new Emplacement($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$id_etagere = isset($_GET["id_etagere"]) ? $_GET["id_etagere"] : "";
$id_rack = isset($_GET["id_rack"]) ? $_GET["id_rack"] : "";
$id_prelevement = isset($_GET["id_prelevement"]) ? $_GET["id_prelevement"] : "";

// make sure data is not empty
if(
   !empty($id_etagere) &&
   !empty($id_prelevement) &&
   !empty($id_rack)
)
{
 
    // set emplacement property values
    $emplacement->id_etagere = $id_etagere;
    $emplacement->id_rack = $id_rack;
    $emplacement->id_prelevement = $id_prelevement;
 
    // create the utilisateur
    if($emplacement->create_single_slot($id_etagere,$id_rack,$id_prelevement)){
 
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