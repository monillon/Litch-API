<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/frigo.php';
 
// instantiate database and frigo object
$database = new Database();
$db = $database->getConnection();
 
 
// initialize object
$frigo = new Frigo($db);
 
// query frigos
$stmt = $frigo->read_all();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // frigos array
    $frigos_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $frigo_item=array(
            "ID_FRIGO" => $id_frigo,
            "NOM_FRIGO" => $nom_frigo,
        );
 
        array_push($frigos_arr, $frigo_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show frigos data in json format
    echo json_encode($frigos_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no frigos found
    echo json_encode(
        array("message" => "Aucun frigo trouvé.")
    );
}