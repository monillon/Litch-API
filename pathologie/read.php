<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/pathologie.php';
 
// instantiate database and pathologie object
$database = new Database();
$db = $database->getConnection();
 
 // get keywords
$id_sujet=isset($_GET["s"]) ? $_GET["s"] : "";

// initialize object
$pathologie = new Pathologie($db);
 
// query pathologies
$stmt = $pathologie->read($id_sujet);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // pathologies array
    $pathologies_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $pathologie_item=array(
            "ID_PATHOLOGIE" => $id_pathologie,
            "NOM_PATHOLOGIE" => $nom_pathologie,
        );
 
        array_push($pathologies_arr, $pathologie_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show pathologies data in json format
    echo json_encode($pathologies_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no pathologies found
    echo json_encode(
        array("message" => "Aucune pathologie trouvée.")
    );
}