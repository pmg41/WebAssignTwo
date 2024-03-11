<?php

header("content-type: application/json"); 
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,  X-Requested-With');


include_once "Database.php";
include_once "OrderFuncProvider.php";

//POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postData = json_decode(file_get_contents("php://input"), true);
    if(empty($postData)){
        $OrderData = insertOrder($_POST);
    }else{
        $OrderData = insertOrder($postData);
    }
}
//GET
else if ($_SERVER["REQUEST_METHOD"] === "GET") {
    fetchAllOrders();
}
//PUT
else if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    $updateData = json_decode(file_get_contents("php://input"), true);
    $oid= $_GET['id'] ?? null ;
    if($oid != null) {
        $updateOrder = updateOrder($updateData,$oid);
        echo $updateOrder;
    }
} 
//DELETE
else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
  $deleteData = json_decode(file_get_contents("php://input"), true);
  $oid= $_GET['id'] ?? null ;
  if($oid != null) {
    $deleteOrder = deleteOrderById($oid);
    echo json_decode($deleteOrder);
  } else {
    echo "Invalid Order id";
  }  

} 
else {
  http_response_code(405);
  echo json_encode(["error" => "Unsupported request method"]);
}

?>