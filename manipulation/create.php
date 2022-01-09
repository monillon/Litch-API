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
include_once '../objects/manipulation.php';
 
$database = new Database();
$db = $database->getConnection();
 
$manipulation = new Manipulation($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$id_utilisateur = isset($_GET["id_utilisateur"]) ? $_GET["id_utilisateur"] : "";
$id_modele_manip = isset($_GET["id_modele_manip"]) ? $_GET["id_modele_manip"] : "";
$id_prelevement = isset($_GET["id_prelevement"]) ? $_GET["id_prelevement"] : "";
$date_heure_manipulation = isset($_GET["date_heure_manipulation"]) ? $_GET["date_heure_manipulation"] : "";
$commentaire_manipulation = isset($_GET["commentaire_manipulation"]) ? $_GET["commentaire_manipulation"] : "";


// make sure data is not empty
if(
   !empty($id_utilisateur) &&
   !empty($id_modele_manip)&&
   !empty($id_prelevement)&&
   !empty($date_heure_manipulation))
{
 
    // set sujet property values
    $manipulation->id_utilisateur = $id_utilisateur;
    $manipulation->id_modele_manip = $id_modele_manip;
    $manipulation->id_prelevement = $id_prelevement;
    $manipulation->date_heure_manipulation = $date_heure_manipulation;
    $manipulation->commentaire_manipulation = $commentaire_manipulation;
 
    // create the sujet
    if($manipulation->create($id_utilisateur,$id_modele_manip,$id_prelevement,$date_heure_manipulation,$commentaire_manipulation)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "manipulation was created."));
    }
 
    // if unable to create the sujet, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create manipulation."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create manipulation. Data is incomplete."));
}

?>