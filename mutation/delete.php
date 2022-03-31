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
include_once '../objects/mutation.php';

$database = new Database();
$db = $database->getConnection();

$mutation = new Mutation($db);

// get posted data
//$data = json_decode(file_get_contents("php://input"));

$id_mutation = isset($_GET["id_mutation"]) ? $_GET["id_mutation"] : "";

// make sure data is not empty
if (!empty($id_mutation)) {

    // set manipulation property values
    $mutation->id_tissu = $id_mutation;

    // delete the manipulation
    if ($mutation->delete($id_mutation)) {

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "mutation was deleted."));
    } // if unable to delete the manipulation, tell the user
    else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to delete mutation."));
    }
} // tell the user data is incomplete
else {

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to delete mutation."));
}

