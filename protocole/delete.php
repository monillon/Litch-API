<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate manipulation object
include_once '../objects/protocole.php';

$database = new Database();
$db = $database->getConnection();

$protoc = new Protocole($db);

// get posted data
//$data = json_decode(file_get_contents("php://input"));

$id_protocole = isset($_GET["id_protocole"]) ? $_GET["id_protocole"] : "";

// make sure data is not empty
if (!empty($id_protocole)) {

    // set manipulation property values
    $protoc->id_protocole = $id_protocole;

    // delete the manipulation
    if ($protoc->delete($id_protocole)) {

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "protocole was deleted."));
    } // if unable to delete the manipulation, tell the user
    else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to delete protocole."));
    }
} // tell the user data is incomplete
else {

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to delete protocole."));
}

