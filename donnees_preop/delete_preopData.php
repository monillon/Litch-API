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
include_once '../objects/donnees_preop.php';

$database = new Database();
$db = $database->getConnection();

$preop_data = new DonneesPreop($db);

// get posted data
//$data = json_decode(file_get_contents("php://input"));

$id_preop = isset($_GET["id_preop"]) ? $_GET["id_preop"] : "";

// make sure data is not empty
if (!empty($id_preop)) {

    // set manipulation property values
    $preop_data->$id_preop = $id_preop;

    // delete the manipulation
    if ($preop_data->delete_preopData($id_preop)) {

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "tissu was deleted."));
    } // if unable to delete the manipulation, tell the user
    else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to delete tissu."));
    }
} // tell the user data is incomplete
else {

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to delete tissu."));
}

