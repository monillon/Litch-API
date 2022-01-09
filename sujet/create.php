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
include_once '../objects/sujet.php';
 
$database = new Database();
$db = $database->getConnection();
 
$sujet = new Sujet($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$code_sujet = isset($_GET["code_sujet"]) ? $_GET["code_sujet"] : "";
$id_grp = isset($_GET["id_grp"]) ? $_GET["id_grp"] : "";
$age_sujet = isset($_GET["age_sujet"]) ? $_GET["age_sujet"] : "";
$uni_id_unite = isset($_GET["uni_id_unite"]) ? $_GET["uni_id_unite"] : "";
$sexe_sujet = isset($_GET["sexe_sujet"]) ? $_GET["sexe_sujet"] : "";
$poids_sujet = isset($_GET["poids_sujet"]) ? $_GET["poids_sujet"] : "";
$id_unite = isset($_GET["id_unite"]) ? $_GET["id_unite"] : "";
$commentaire_sujet = $_GET["commentaire_sujet"];

// make sure data is not empty
if(
   !empty($code_sujet) &&
   !empty($id_grp)&&
   !empty($age_sujet)&&
   !empty($sexe_sujet)&&
   !empty($poids_sujet)&&
   !empty($id_unite)&&
   !empty($uni_id_unite))
{
 
    // set sujet property values
    $sujet->code_sujet = $code_sujet;
    $sujet->id_grp = $id_grp;
    $sujet->age_sujet = $age_sujet;
    $sujet->sexe_sujet = $sexe_sujet;
    $sujet->poids_sujet = $poids_sujet;
    $sujet->commentaire_sujet = $commentaire_sujet;
    $sujet->uni_id_unite = $uni_id_unite;
    $sujet->id_unite = $id_unite;

 
    // create the sujet
    if($sujet->create($code_sujet,$id_grp,$age_sujet,$sexe_sujet,$poids_sujet,$commentaire_sujet,$uni_id_unite,$id_unite)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "sujet was created."));
    }
 
    // if unable to create the sujet, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create sujet."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create sujet. Data is incomplete."));
}

?>