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
include_once '../objects/mutation.php';
 
$database = new Database();
$db = $database->getConnection();
 
$mutation = new Mutation($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$id_pathologie = isset($_GET["id_pathologie"]) ? $_GET["id_pathologie"] : "";
$nom_mutation = isset($_GET["nom_mutation"]) ? $_GET["nom_mutation"] : "";

// make sure data is not empty
if(!empty($id_pathologie)&&!empty($nom_mutation))
{
 
    // set sujet property values
    $mutation->id_pathologie = $id_pathologie;
    $mutation->nom_mutation = $nom_mutation;
    
    // create the sujet
    if($mutation->create($id_pathologie,$nom_mutation)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Mutation was created."));
    }
 
    // if unable to create the sujet, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create Mutation."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create Mutation. Data is incomplete."));
}

?>