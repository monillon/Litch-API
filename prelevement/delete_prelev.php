<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate prelevement object
include_once '../objects/prelevement.php';
 
$database = new Database();
$db = $database->getConnection();
 
$prelevement = new Prelevement($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$id_prelevement = isset($_GET["id_prelevement"]) ? $_GET["id_prelevement"] : "";

// make sure data is not empty
if(!empty($id_prelevement))
{
 
    // set prelevement property values
    $prelevement->id_prelevement = $id_prelevement;
 
    // delete the prelevement
    if($prelevement->delete_prelev($id_prelevement)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "prelevement was deleted."));
    }
 
    // if unable to delete the prelevement, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to delete prelevement."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete prelevement."));
}

?>