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
 
$id_unite = isset($_GET["id_unite"]) ? $_GET["id_unite"] : "";
$id_preop = isset($_GET["id_preop"]) ? $_GET["id_preop"] : "";
$id_sujet = isset($_GET["id_sujet"]) ? $_GET["id_sujet"] : "";
$id_pathologie = isset($_GET["id_pathologie"]) ? $_GET["id_pathologie"] : "";
$id_prescription = isset($_GET["id_prescription"]) ? $_GET["id_prescription"] : "";
$id_mutation = isset($_GET["id_mutation"]) ? $_GET["id_mutation"] : "";
$valeur_preop = isset($_GET["valeur_preop"]) ? $_GET["valeur_preop"] : "";

// make sure data is not empty
if(!empty($id_sujet))
{
 
    // set phenotype property values
    $phenotype->id_unite = $id_unite;
    $phenotype->id_preop = $id_preop;
    $phenotype->id_sujet = $id_sujet;
    $phenotype->id_pathologie = $id_pathologie;
    $phenotype->id_prescription = $id_prescription;
    $phenotype->id_mutation = $id_mutation;
    $phenotype->valeur_preop = $valeur_preop;
    // create the phenotype
    if($phenotype->create_pheno_preop($id_unite,$id_preop,$id_sujet,$id_pathologie,$id_prescription,$id_mutation,$valeur_preop)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Phenotype was created."));
    }
 
    // if unable to create the phenotype, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create Phenotype."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create Phenotype. Data is incomplete."));
}

?>