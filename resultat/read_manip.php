<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/resultat.php';
 
// instantiate database and resultat object
$database = new Database();
$db = $database->getConnection();
 
 // get keywords
$id_manip=isset($_GET["s"]) ? $_GET["s"] : "";

// initialize object
$resultat = new Resultat($db);
 
// query resultats
$stmt = $resultat->read_manip($id_manip);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // resultats array
    $resultats_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $resultat_item=array(
            "ID_RESULTAT" => $id_resultat,
            "ID_MANIPULATION" => $id_manipulation,
            "STOCKAGE_RESULTAT_BRUT" => $stockage_resultat_brut,
            "DATE_HEURE_BRUT" => $date_heure_brut,
            "STOCKAGE_RESULTAT_ANALYSE" => $stockage_resulat_analyse,
            "DATE_HEURE_ANALYSE" => $date_heure_analyse
        );
 
        array_push($resultats_arr, $resultat_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show resultats data in json format
    echo json_encode($resultats_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no resultats found
    echo json_encode(
        array("message" => "Aucun resultat trouvé.")
    );
}