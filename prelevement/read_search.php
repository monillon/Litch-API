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
$id_projet=isset($_GET["id_projet"]) ? $_GET["id_projet"] : "";
$search=isset($_GET["search"]) ? $_GET["search"] : "";

// initialize object
$prelevement = new Prelevement($db);
 
// query Prelevements
$stmt = $prelevement->read_search($id_projet,$search);
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
            "CODE SUJET" => $code_sujet,
            "NOM ORGANE" => $nom_organe,
            "NOM TISSU" => $nom_tissu,
            "LOCALISATION" => $nom_frigo . " / " . $nom_etagere . " / " . $id_rack . " / " . $id_boite . " / " . $coordonnee_x . $coordonnee_y,
            "DATE PRELEVEMENT" => $date_heure_prelevement,
            "COMMENTAIRE PRELEVEMENT" => $commentaire_prelevement
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
        array("message" => "Aucun prelevement trouvé pour ce sujet.")
    );
}