<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/role.php';
 
// instantiate database and role object
$database = new Database();
$db = $database->getConnection();
 
 // get keywords
$nom_r=isset($_GET["nom_role"]) ? $_GET["nom_role"] : "";

// initialize object
$role = new Role($db);
 
// query roles
$stmt = $role->read_one($nom_r);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // roles array
    $role_arr=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
         $role_item=array(
            "ID_ROLE" => $id_role,
            "NOM_ROLE" => $nom_role,
        );
 
        array_push($role_arr, $role_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show roles data in json format
    echo json_encode($role_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no role found
    echo json_encode(
        array("message" => "Aucun role trouvé.")
    );
}