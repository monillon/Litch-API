<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/liste_manip.php';
 
// instantiate database and liste_manip object
$database = new Database();
$db = $database->getConnection();
 
 
// initialize object
$liste_manip = new ListeManip($db);
 
// query liste_manips
$stmt = $liste_manip->read_all();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // liste_manips array
    $liste_manips_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $liste_manip_item=array(
            "ID_LISTE_MANIP" => $id_liste_manip,
            "ID_CATEGORIE_MANIP" => $id_categorie_manip,
            "NOM_LISTE_MANIP" => $nom_liste_manip,
            "DESCRIPTION_LISTE_MANIP" => $description_liste_manip

        );
 
        array_push($liste_manips_arr, $liste_manip_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show liste_manips data in json format
    echo json_encode($liste_manips_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no liste_manips found
    echo json_encode(
        array("message" => "Aucune liste_manip trouvée.")
    );
}