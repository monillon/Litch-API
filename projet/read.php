<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/projet.php';
 
// instantiate database and projet object
$database = new Database();
$db = $database->getConnection();
 
 // get keywords
$s=isset($_GET["s"]) ? $_GET["s"] : "";

// initialize object
$projet = new Projet($db);
 
// query projets
$stmt = $projet->read($s);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // projets array
    $projets_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $projet_item=array(
            "ID_PROJET" => $id_projet,
            "CODE_PROJET" => $code_projet,
            "NOM_PROJET" => $nom_projet,
            "IMG_PROJET" => $img_projet,
        );
 
        array_push($projets_arr, $projet_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show projets data in json format
    echo json_encode($projets_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no projets found
    echo json_encode(
        array("message" => "No projets found.")
    );
}