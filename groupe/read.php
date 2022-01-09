<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/groupe.php';
 
// instantiate database and groupe object
$database = new Database();
$db = $database->getConnection();
 
 // get keywords
$id_projet=isset($_GET["a"]) ? $_GET["a"] : "";
$id_organisme=isset($_GET["b"]) ? $_GET["b"] : "";

// initialize object
$groupe = new groupe($db);
 
// query groupes
$stmt = $groupe->read($id_projet, $id_organisme);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // groupes array
    $groupes_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $groupe_item=array(
            "ID_GRP" => $id_grp,
            "ID_ORGANISME" => $id_organisme,
            "ID_groupe" => $id_groupe,
            "CODE_GRP" => $code_grp,
            "NOM_GRP" => $nom_grp,
            "GRP_PATHO" => $grp_patho,
            "GRP_TRAITE" => $grp_traite,
            "NB_MEMBRE" => $nb_membre,
        );
 
        array_push($groupes_arr, $groupe_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show groupes data in json format
    echo json_encode($groupes_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no groupes found
    echo json_encode(
        array("message" => "No groupes found.")
    );
}