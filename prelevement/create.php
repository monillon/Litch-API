<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate prelevement object
include_once '../objects/prelevement.php';
 
$database = new Database();
$db = $database->getConnection();
 
$prelevement = new Prelevement($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$id_sujet = isset($_GET["id_sujet"]) ? $_GET["id_sujet"] : "";
$date_heure_prelevement = isset($_GET["date_heure_prelevement"]) ? $_GET["date_heure_prelevement"] : "";
$id_organe = isset($_GET["id_organe"]) ? $_GET["id_organe"] : "";
$id_tissu = isset($_GET["id_tissu"]) ? $_GET["id_tissu"] : "";
$commentaire_prelevement = $_GET["commentaire_prelevement"];

// make sure data is not empty
if(
   !empty($id_sujet)&&
   !empty($date_heure_prelevement)&&
   !empty($id_organe)&&
   !empty($id_tissu)
)
{
 
    // set prelevement property values
    $prelevement->id_sujet = $id_sujet;
    $prelevement->date_heure_prelevement = $date_heure_prelevement;
    $prelevement->id_organe = $id_organe;
    $prelevement->id_tissu = $id_tissu;
    $prelevement->commentaire_prelevement = $commentaire_prelevement;

 
    // create the prelevement
    if($prelevement->create($id_sujet,$date_heure_prelevement,$id_organe,$id_tissu,$commentaire_prelevement)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "prelevement was created."));
    }
 
    // if unable to create the prelevement, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create prelevement."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create prelevement. Data is incomplete."));
}

?>