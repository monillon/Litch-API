<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/sujet.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$s=isset($_GET["s"]) ? $_GET["s"] : "";

 
// initialize object
$sujet = new Sujet($db);
 
// query products
$stmt = $sujet->read($s);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
    // products array
    $sujet_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $sujet_item=array(
            "ID_SUJET" => $id_sujet,
            "ID_GRP" => $id_grp,
            "ID_UNITE" => $id_unite,
            "UNI_ID_UNITE" => $uni_id_unite,
            "CODE_SUJET" => $code_sujet,
            "AGE_SUJET" => $age_sujet,
            "SEXE_SUJET" => $sexe_sujet,
            "POIDS_SUJET" => $poids_sujet,
            "COMMENTAIRE_SUJET" => $commentaire_sujet,
        );
 
        array_push($sujet_arr,$sujet_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($sujet_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No Subject found.")
    );
}
