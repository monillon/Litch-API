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
 
$id_boite = isset($_GET["id_boite"]) ? $_GET["id_boite"] : "";

// make sure data is not empty
if(!empty($id_boite))
{
 
    // set emplacement property values
    $emplacement->id_boite = $id_boite;
 
    // delete the emplacement
    if($emplacement->delete_slot($id_boite)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "emplacement was deleted."));
    }
 
    // if unable to delete the emplacement, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to delete emplacement."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete emplacement."));
}

?>