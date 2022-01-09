<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/technique.php';
 
// instantiate database and technique object
$database = new Database();
$db = $database->getConnection();
 
 
// initialize object
$technique = new Technique($db);
 
// query techniques
$stmt = $technique->read_all();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // techniques array
    $techniques_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $technique_item=array(
            "ID_TECHNIQUE" => $id_technique,
            "NOM_TECHNIQUE" => $nom_technique,            
            "DESCRIPTION_TECHNIQUE" => $description_technique,
        );
 
        array_push($techniques_arr, $technique_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show techniques data in json format
    echo json_encode($techniques_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no techniques found
    echo json_encode(
        array("message" => "Aucune technique trouvée.")
    );
}