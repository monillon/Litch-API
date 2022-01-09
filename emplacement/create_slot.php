<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate emplacement object
include_once '../objects/emplacement.php';
 
$database = new Database();
$db = $database->getConnection();
 
$emplacement = new Emplacement($db);
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));
 
//$id_etagere = 1;
//$id_boite = 1;

// make sure data is not empty
//if(1=1)
//{
 
    // set emplacement property values
    //$emplacement->id_etagere = $id_etagere;
    $emplacement->coordonnee_x = $coordonnee_x;
    $emplacement->coordonnee_y = $coordonnee_y;
    $emplacement->id_boite = $id_boite;
 
 $list = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
 for ($u = 1; $u<5; $u++)
{
 for ($i = 0; $i<13; $i++)
 {
    if ($y >=9)
    {
        $y = 0;
    }
    $y++;
    $x = $i/9;
    $coordonnee_x = $list[$x];
    echo ($coordonnee_x);
    $coordonnee_y = $y;
    echo ($coordonnee_y);
    $id_boite = $u;
    // create the emplacement
    if($emplacement->create_slot($coordonnee_x,$coordonnee_y,$id_boite)){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "emplacement was created."));
    }
 
    // if unable to create the emplacement, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create emplacement."));
    }
}
}
//}

 
// tell the user data is incomplete
//else{
 
    // set response code - 400 bad request
//    http_response_code(400);
 
    // tell the user
//    echo json_encode(array("message" => "Unable to create emplacement. Data is incomplete."));
//}

?>