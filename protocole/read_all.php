<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/protocole.php';
 
// instantiate database and protocole object
$database = new Database();
$db = $database->getConnection();
 
 
// initialize object
$protocole = new Protocole($db);
 
// query protocoles
$stmt = $protocole->read_all();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // protocoles array
    $protocoles_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $protocole_item=array(
            "ID_PROTOCOLE" => $id_protocole,
            "NOM_PROTOCOLE" => $nom_protocole,            

        );
 
        array_push($protocoles_arr, $protocole_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show protocoles data in json format
    echo json_encode($protocoles_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no protocoles found
    echo json_encode(
        array("message" => "Aucun protocole trouvé.")
    );
}