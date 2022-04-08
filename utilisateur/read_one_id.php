<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/utilisateur.php';

// instantiate database and utilisateur object
$database = new Database();
$db = $database->getConnection();

// get keywords
$id_user=isset($_GET["id_user"]) ? $_GET["id_user"] : "";


// initialize object
$utilisateur = new Utilisateur($db);

// query utilisateurs
$stmt = $utilisateur->read_one_id($id_user);
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
    // set response code - 200 OK
    http_response_code(200);

    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
} else {

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no emplacements found
    echo json_encode(
        array("message" => "Aucun id utilisateur trouvé pour cet id.")
    );
}