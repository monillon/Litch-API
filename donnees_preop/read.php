<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/donnees_preop.php';
 
// instantiate database and donnees_preop object
$database = new Database();
$db = $database->getConnection();
 
 // get keywords
$id_s=isset($_GET["s"]) ? $_GET["s"] : "";

// initialize object
$donnees_preop = new DonneesPreop($db);
 
// query donnees_preops
$stmt = $donnees_preop->read($id_s);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // donnees_preops array
    $preop_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $preop_item=array(
            "ID_PREOP" => $id_preop,
            "NOM_PREOP" => $nom_preop,
            "VALEUR_PREOP" =>$valeur_preop,
            "NOM_UNITE" => $nom_unite,
        );
 
        array_push($preop_arr, $preop_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show donnees_preops data in json format
    echo json_encode($preop_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no donnees_preops found
    echo json_encode(
        array("message" => "Aucune donnees_preop trouvée.")
    );
}