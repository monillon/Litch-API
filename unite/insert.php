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
include_once '../objects/unite.php';
 
$database = new Database();
$db = $database->getConnection();
 
$unite = new Unite($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$nom_unite = isset($_GET["nom_unite"]) ? $_GET["nom_unite"] : "";
$description_unite = isset($_GET["description_unite"]) ? $_GET["description_unite"] : "";

// make sure data is not empty
if(!empty($nom_unite) && !empty($description_unite))
{
 
    // set unit property values
    $unite->nom_unite = $nom_unite;
    $unite->description_unite = $description_unite;

    // create the unit
    if($unite->create($nom_unite,$description_unite)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Unite was created."));
    }
 
    // if unable to create the sujet, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create Unite."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create Unite. Data is incomplete."));
}

?>