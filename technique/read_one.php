<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/technique.php';

// instantiate database and emplacement object
$database = new Database();
$db = $database->getConnection();

// get keywords
$id_technique = isset($_GET["id_technique"]) ? $_GET["id_technique"] : "";


// initialize object
$technique = new Technique($db);

// query emplacements
$stmt = $technique->read_one($id_technique);
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {
    // set response code - 200 OK
    http_response_code(200);

    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
} else {

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no emplacements found
    echo json_encode(
        array("message" => "Aucune id technique.")
    );
}