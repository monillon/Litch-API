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
include_once '../objects/CategorieManipulation.php';

$database = new Database();
$db = $database->getConnection();

$catManip = new CategorieManipulation($db);

// get posted data
//$data = json_decode(file_get_contents("php://input"));

$nom_catManip = isset($_GET["nom_catManip"]) ? $_GET["nom_catManip"] : "";

// make sure data is not empty
if(!empty($nom_catManip))
{

    // set sujet property values
    $catManip->nom_categorie_manip = $nom_catManip;

    // create the sujet
    if($catManip->create($nom_catManip)){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "category was created."));
    }

    // if unable to create the sujet, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create category."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create category. Data is incomplete."));
}

?>