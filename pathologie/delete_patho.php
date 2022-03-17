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
include_once '../objects/pathologie.php';

$database = new Database();
$db = $database->getConnection();

$patho = new Pathologie($db);

// get posted data
//$data = json_decode(file_get_contents("php://input"));

$id_patho = isset($_GET["id_patho"]) ? $_GET["id_patho"] : "";

// make sure data is not empty
if (!empty($id_patho)) {

    // set manipulation property values
    $patho->id_pathologie = $id_patho;

    // delete the manipulation
    if ($patho->delete_patho($id_patho)) {

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "pathology was deleted."));
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

