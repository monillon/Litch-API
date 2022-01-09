<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/prelevement.php';
 
// instantiate database and Prelevement object
$database = new Database();
$db = $database->getConnection();
 
 // get keywords
$id_p=isset($_GET["id_p"]) ? $_GET["id_p"] : "";

// initialize object
$prelevement = new Prelevement($db);
 
// query Prelevements
$stmt = $prelevement->read_sample($id_p);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // Prelevements array
    $prelevements_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $prelevement_item=array(
            "NOM_ORGANE" => $nom_organe,
            "NOM_TISSU" => $nom_tissu,
            "DATE_HEURE_PRELEVEMENT" => $date_heure_prelevement,
            "CODE_SUJET" => $code_sujet
        );
 
        array_push($prelevements_arr, $prelevement_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show Prelevements data in json format
    echo json_encode($prelevements_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no Prelevements found
    echo json_encode(
        array("message" => "Aucun prelevement trouvé.")
    );
}