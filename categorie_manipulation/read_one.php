<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/CategorieManipulation.php';

// instantiate database and emplacement object
$database = new Database();
$db = $database->getConnection();

// get keywords
$id_catManip = isset($_GET["id_catManip"]) ? $_GET["id_catManip"] : "";


// initialize object
$catManip = new CategorieManipulation($db);

// query emplacements
$stmt = $catManip->read_one($id_catManip);
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
        array("message" => "Aucun id de catégorie trouvé.")
    );
}