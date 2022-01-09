<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate phenotype object
include_once '../objects/phenotype.php';
 
$database = new Database();
$db = $database->getConnection();
 
$phenotype = new Phenotype($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$id_sujet = isset($_GET["id_sujet"]) ? $_GET["id_sujet"] : "";
$id_pathologie = $_GET["id_pathologie"];
$id_prescription = $_GET["id_prescription"];
$id_mutation = $_GET["id_mutation"];

// make sure data is not empty
if(
   !empty($id_sujet))
{
 
    // set phenotype property values
    $phenotype->id_sujet = $id_sujet;
    $phenotype->id_pathologie = $id_pathologie;
    $phenotype->id_prescription = $id_prescription;
    $phenotype->id_mutation = $id_mutation;

 
    // create the phenotype
    if($phenotype->create($id_sujet,$id_pathologie,$id_prescription,$id_mutation)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "phenotype was created."));
    }
 
    // if unable to create the phenotype, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create phenotype."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create phenotype. Data is incomplete."));
}

?>