<?php

header("content-type: application/json"); 
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,  X-Requested-With');


include_once "Database.php";
include_once "FuncProvider.php";

//POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postData = json_decode(file_get_contents("php://input"), true);
    if(empty($postData)){
        $OrderData = insertOrder($_POST);
        echo json_encode($OrderData);
    }else{
        $OrderData = insertOrder($postData);
        echo json_encode($OrderData);
    }
}
//GET
else if ($_SERVER["REQUEST_METHOD"] === "GET") {
  fetchAllOrders();
}
//PUT
else if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    $updateData = json_decode(file_get_contents("php://input"), true);
    $pid= $_GET['id'] ?? null ;
    $updateOrder = updateOrder($updateData,$pid);
    echo $updateOrder;
} 
//DELETE
else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
  $deleteData = json_decode(file_get_contents("php://input"), true);
  $pid= $_GET['id'] ?? null ;
  if($pid != null) {
    $deleteOrder = deleteOrderById($pid);
    echo $deleteOrder;
  } else {
    echo "Invalid Order id";
  }  

} 
else {
  http_response_code(405);
  echo json_encode(["error" => "Unsupported request method"]);
}

?>