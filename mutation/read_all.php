<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/mutation.php';
 
// instantiate database and mutation object
$database = new Database();
$db = $database->getConnection();
 
 
// initialize object
$mutation = new Mutation($db);
 
// query mutations
$stmt = $mutation->read_all();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // mutations array
    $mutations_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $mutation_item=array(
            "ID_MUTATION" => $id_mutation,
            "NOM_MUTATION" => $nom_mutation,
            "CLASSE_MUTATION" =>$classe_mutation
        );
 
        array_push($mutations_arr, $mutation_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show mutations data in json format
    echo json_encode($mutations_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no mutations found
    echo json_encode(
        array("message" => "Aucune mutation trouvée.")
    );
}