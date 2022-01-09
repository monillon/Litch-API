<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/organisme.php';
 
// instantiate database and organisme object
$database = new Database();
$db = $database->getConnection();
 
 
// initialize object
$organisme = new Organisme($db);
 
// query organismes
$stmt = $organisme->read_all();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // organismes array
    $organismes_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $organisme_item=array(
            "ID_ORGANISME" => $id_organisme,
            "NOM_ORGANISME" => $nom_organisme,
        );
 
        array_push($organismes_arr, $organisme_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show organismes data in json format
    echo json_encode($organismes_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no organismes found
    echo json_encode(
        array("message" => "Aucun organisme trouvé.")
    );
}