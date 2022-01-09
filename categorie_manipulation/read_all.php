<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/categorie_manipulation.php';
 
// instantiate database and categorie_manipulation object
$database = new Database();
$db = $database->getConnection();
 
 
// initialize object
$categorie_manipulation = new CategorieManipulation($db);
 
// query categorie_manipulations
$stmt = $categorie_manipulation->read_all();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // categorie_manipulations array
    $categorie_manipulations_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $categorie_manipulation_item=array(
            "ID_CATEGORIE_MANIP" => $id_categorie_manip,
            "NOM_CATEGORIE_MANIP" => $nom_categorie_manip,
        );
 
        array_push($categorie_manipulations_arr, $categorie_manipulation_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show categorie_manipulations data in json format
    echo json_encode($categorie_manipulations_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no categorie_manipulations found
    echo json_encode(
        array("message" => "Aucun categorie_manipulation trouvé.")
    );
}