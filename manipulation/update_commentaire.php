<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate location object
include_once '../objects/manipulation.php';
 
$database = new Database();
$db = $database->getConnection();
 
$manipulation = new Manipulation($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
$commentaire_manipulation = isset($_GET["commentaire_manipulation"]) ? $_GET["commentaire_manipulation"] : "";
$id_manipulation = isset($_GET["id_manipulation"]) ? $_GET["id_manipulation"] : "";

// make sure data is not empty
if(!empty($commentaire_manipulation))
{
     if(empty($commentaire_manipulation)){
        $commentaire_manipulation=null;
    }

    // set location property values
    $manipulation->commentaire_manipulation = $commentaire_manipulation;
    $manipulation->id_manipulation = $id_manipulation;
    // update the location
    if($manipulation->update($commentaire_manipulation,$id_manipulation)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "commentaire was updated."));
    }
 
    // if unable to update the location, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to update commentaire."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update commentaire. Data is incomplete."));
}

?>