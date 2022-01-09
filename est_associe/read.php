<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/est_associe.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$est_associe = new Est_Associe($db);
 
// query products
$stmt = $est_associe->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
    // products array
    $est_associe_arr=array();
    $est_associe_arr["ID_UTILISATEUR"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $est_associe_item=array(
            "ID_UTILISATEUR" => $id_utilisateur,
            "ID_PROJET" => $id_projet,
        );
 
        array_push($est_associe_arr["ID_UTILISATEUR"], $est_associe_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($est_associe_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}
