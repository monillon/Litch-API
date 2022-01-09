<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/organe.php';
 
// instantiate database and organe object
$database = new Database();
$db = $database->getConnection();
 
 
// initialize object
$organe = new Organe($db);
 
// query organes
$stmt = $organe->read_all();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // organes array
    $organes_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $organe_item=array(
            "ID_ORGANE" => $id_organe,
            "NOM_ORGANE" => $nom_organe,
        );
 
        array_push($organes_arr, $organe_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show organes data in json format
    echo json_encode($organes_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no organes found
    echo json_encode(
        array("message" => "Aucun organe trouvé.")
    );
}