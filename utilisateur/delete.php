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
include_once '../objects/utilisateur.php';

$database = new Database();
$db = $database->getConnection();

$user = new Utilisateur($db);

// get posted data
//$data = json_decode(file_get_contents("php://input"));

$id_user = isset($_GET["id_user"]) ? $_GET["id_user"] : "";

// make sure data is not empty
if (!empty($id_user)) {

    // set manipulation property values
    $user->$id_user = $id_user;

    // delete the manipulation
    if ($user->delete($id_user)) {

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "User was deleted."));
    } // if unable to delete the manipulation, tell the user
    else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to delete the user."));
    }
} // tell the user data is incomplete
else {

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to delete the user."));
}

