<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/modele_manip.php';
 
// instantiate database and modele_manip object
$database = new Database();
$db = $database->getConnection();
 
 
// initialize object
$modele_manip = new ModeleManip($db);
 
// query modele_manips
$stmt = $modele_manip->read_all();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // modele_manips array
    $modele_manips_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $modele_manip_item=array(
            "ID_MODELE_MANIP" => $id_modele_manip,
            "ID_PROTOCOLE" => $id_protocole,
            "ID_LISTE_MANIP" => $id_liste_manip,
            "ID_TECHNIQUE" => $id_technique,            
            "NOM_MODELE_MANIP" => $nom_modele_manip

        );
 
        array_push($modele_manips_arr, $modele_manip_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show modele_manips data in json format
    echo json_encode($modele_manips_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no modele_manips found
    echo json_encode(
        array("message" => "Aucun modele_manip trouvé.")
    );
}