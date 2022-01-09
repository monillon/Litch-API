<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/tracabilite.php';
 
// instantiate database and tissu object
$database = new Database();
$db = $database->getConnection();
 
 
// initialize object
$trace = new Tracabilite($db);
 
// query tissus
$stmt = $trace->read_all();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // tissus array
    $tissus_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $tissu_item=array(
            "ID_TRACE" => $id_tissu,
            "ID_UTILISATEUR" => $id_utilisateur,
            "DATE" => $date,
            "ACTION" => $action
        );
 
        array_push($tissus_arr, $tissu_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show tissus data in json format
    echo json_encode($tissus_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no tissus found
    echo json_encode(
        array("message" => "Aucune trace trouvé.")
    );
}