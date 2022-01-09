<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/prescription.php';
 
// instantiate database and prescription object
$database = new Database();
$db = $database->getConnection();
 
 // get keywords
$id_s=isset($_GET["s"]) ? $_GET["s"] : "";

// initialize object
$prescription = new Prescription($db);
 
// query prescriptions
$stmt = $prescription->read_all();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // prescriptions array
    $prescriptions_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $prescription_item=array(
            "ID_PRESCRIPTION" => $id_prescription,
            "NOM_PRESCRIPTION" => $nom_prescription
        );
 
        array_push($prescriptions_arr, $prescription_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show prescriptions data in json format
    echo json_encode($prescriptions_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no prescriptions found
    echo json_encode(
        array("message" => "Aucune prescription trouvée.")
    );
}