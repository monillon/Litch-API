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
include_once '../objects/groupe.php';
 
$database = new Database();
$db = $database->getConnection();
 
$groupe = new Groupe($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$id_organisme = isset($_GET["id_organisme"]) ? $_GET["id_organisme"] : "";
$id_projet = isset($_GET["id_projet"]) ? $_GET["id_projet"] : "";
$code_grp = isset($_GET["code_grp"]) ? $_GET["code_grp"] : "";
$nom_grp = isset($_GET["nom_grp"]) ? $_GET["nom_grp"] : "";
$grp_patho = isset($_GET["grp_patho"]) ? $_GET["grp_patho"] : "";
$grp_traite = isset($_GET["grp_traite"]) ? $_GET["grp_traite"] : "";

// make sure data is not empty
if(!empty($id_organisme)&& !empty($id_projet)&& !empty($code_grp)&& !empty($nom_grp))
{
 
    // set group property values
    $groupe->id_organisme = $id_organisme;
    $groupe->id_projet = $id_projet;
    $groupe->code_grp = $code_grp;
    $groupe->nom_grp = $nom_grp;
    $groupe->grp_patho = $grp_patho;
    $groupe->grp_traite = $grp_traite;
    // create the group
    if($groupe->create($id_organisme,$id_projet,$code_grp,$nom_grp,$grp_patho,$grp_traite)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Group was created."));
    }
 
    // if unable to create the sujet, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create Group."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create Group. Data is incomplete."));
}

?>