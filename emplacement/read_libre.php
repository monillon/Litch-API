<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/emplacement.php';
 
// instantiate database and emplacement object
$database = new Database();
$db = $database->getConnection();
 
 // get keywords
$id_etagere=isset($_GET["id_etagere"]) ? $_GET["id_etagere"] : "";
$id_boite=isset($_GET["id_boite"]) ? $_GET["id_boite"] : "";
$id_rack=isset($_GET["id_rack"]) ? $_GET["id_rack"] : "";

// initialize object
$emplacement = new Emplacement($db);
 
// query emplacements
$stmt = $emplacement->read_libre($id_etagere,$id_boite,$id_rack);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // emplacements array
    $emplacements_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $emplacement_item=array(
            "ID_EMPLACEMENT" => $id_emplacement,
            "NOM_FRIGO" => $nom_frigo,
            "NOM_ETAGERE" => $nom_etagere,
            "ID_ETAGERE" => $id_etagere,
            "ID_RACK" => $id_rack,
            "ID_FRIGO" => $id_frigo,
            "COORDONNEE_X" => $coordonnee_x,
            "COORDONNEE_Y" => $coordonnee_y,
            "LIBRE" => $libre,
            "ID_BOITE" => $id_boite,
        );
 
        array_push($emplacements_arr, $emplacement_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show emplacements data in json format
    echo json_encode($emplacements_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no emplacements found
    echo json_encode(
        array("message" => "Aucun emplacement trouv?? pour ce prelevement.")
    );
}