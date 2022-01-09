<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/sujet.php';
include_once '../objects/unite.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$id_projet=isset($_GET["id_projet"]) ? $_GET["id_projet"] : "";
$search=isset($_GET["search"]) ? $_GET["search"] : "";
 
// initialize object
$sujet = new Sujet($db);
 
// query products
$stmt = $sujet->read_search($id_projet, $search);
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
                "CODE SUJET" => $code_sujet,
                "AGE SUJET" => $age_sujet .' '. $unite_age,
                "SEXE SUJET" => $sexe_sujet,
                "POIDS SUJET" => $poids_sujet .' '. $unite_poids,
                "COMMENTAIRE SUJET" => $commentaire_sujet,
                "PATHOLOGIE" => $nom_patho,
                "ORGANISME" => $organisme
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