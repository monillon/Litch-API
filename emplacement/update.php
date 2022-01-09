<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate location object
include_once '../objects/emplacement.php';
 
$database = new Database();
$db = $database->getConnection();
 
$emplacement = new Emplacement($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$id_emplacement = isset($_GET["id_emplacement"]) ? $_GET["id_emplacement"] : "";
$libre = isset($_GET["libre"]) ? $_GET["libre"] : "";
$id_prelevement = isset($_GET["id_prelevement"]) ? $_GET["id_prelevement"] : "";

// make sure data is not empty
if(!empty($id_emplacement))
{
     if(empty($id_prelevement)){
        $id_prelevement=null;
    }

    // set location property values
    $emplacement->id_emplacement = $id_emplacement;
    $emplacement->libre = $libre;
    $emplacement->id_prelevement = $id_prelevement;
    // update the location
    if($emplacement->update($id_emplacement,$libre,$id_prelevement)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "location was updated."));
    }
 
    // if unable to update the location, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to update location."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update location. Data is incomplete."));
}

?>