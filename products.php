<?php

header("content-type: application/json"); 
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,  X-Requested-With');


include_once "Database.php";
include_once "ProductFuncProvider.php";

//POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postData = json_decode(file_get_contents("php://input"), true);
    if(empty($postData)){
        $productData = insertProduct($_POST);
    }else{
        $productData = insertProduct($postData);
    }
}
//GET
else if ($_SERVER["REQUEST_METHOD"] === "GET") {
  fetchAllProducts();
}
//PUT
else if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    $updateData = json_decode(file_get_contents("php://input"), true);
    $pid= $_GET['id'] ?? null ;
    $updateProduct = updateProduct($updateData,$pid);
    echo $updateProduct;
} 
//DELETE
else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
  $deleteData = json_decode(file_get_contents("php://input"), true);
  $pid= $_GET['id'] ?? null ;
  if($pid != null) {
    $deleteProduct = deleteProductById($pid);
    echo $deleteProduct;
  } else {
    echo "Invalid product id";
  }  

} 
else {
  http_response_code(405);
  echo json_encode(["error" => "Unsupported request method"]);
}

?>