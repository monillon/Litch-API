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
include_once '../objects/tracabilite.php';
 
$database = new Database();
$db = $database->getConnection();
 
$trace = new Tracabilite($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$id_user = isset($_GET["id_user"]) ? $_GET["id_user"] : "";
$date = isset($_GET["date"]) ? $_GET["date"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "";

// make sure data is not empty
if(!empty($id_user)&
    !empty($date)&
    !empty($action))
{
 
    // set sujet property values
    $trace->id_user = $id_user;
    $trace->date = $date;
    $trace->action = $action;
    
    // create the sujet
    if($trace->create($id_user, $date, $action)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Trace was created."));
    }
 
    // if unable to create the sujet, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create trace."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create trace. Data is incomplete."));
}

?>