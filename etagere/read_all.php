<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/etagere.php';
 
// instantiate database and etagere object
$database = new Database();
$db = $database->getConnection();
 
 
// initialize object
$etagere = new Etagere($db);
 
// query etageres
$stmt = $etagere->read_all();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // etageres array
    $etageres_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $etagere_item=array(
            "ID_ETAGERE" => $id_etagere,
            "ID_FRIGO" => $id_frigo,            
            "NOM_ETAGERE" => $nom_etagere,
        );
 
        array_push($etageres_arr, $etagere_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show etageres data in json format
    echo json_encode($etageres_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no etageres found
    echo json_encode(
        array("message" => "Aucun etagere trouvé.")
    );
}