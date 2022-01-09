<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/manipulation.php';
 
// instantiate database and manipulation object
$database = new Database();
$db = $database->getConnection();
 
 // get keywords
$id_projet=isset($_GET["id_projet"]) ? $_GET["id_projet"] : "";
$search=isset($_GET["search"]) ? $_GET["search"] : "";

// initialize object
$manipulation = new Manipulation($db);
 
// query manipulations
$stmt = $manipulation->read_search($id_projet,$search);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // manipulations array
    $manipulations_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $manipulation_item=array(
            "CODE SUJET" => $CODE_SUJET,
            "NOM MANIPULATEUR" => $NOM_UTILISATEUR,
            "DATE MANIPULATION" => $DATE_HEURE_MANIPULATION,
            "COMMENTAIRE" => $COMMENTAIRE_MANIPULATION,
            "ORGANE" => $NOM_ORGANE,
            "TISSU" => $NOM_TISSU,
 
        );
 
        array_push($manipulations_arr, $manipulation_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show manipulations data in json format
    echo json_encode($manipulations_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no manipulations found
    echo json_encode(
        array("message" => "Aucune manipulation trouvée.")
    );
}