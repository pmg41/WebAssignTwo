<?php

header("content-type: application/json"); 
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,  X-Requested-With');


include_once "Database.php";
include_once "UserFuncProvider.php";

//POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postData = json_decode(file_get_contents("php://input"), true);
    if(empty($postData)){
        $userData = insertUser($_POST);
        // echo $userData;
    }else{
        $userData = insertUser($postData);
        // echo $userData;
    }
    // echo json_encode($postData);
}
//GET
else if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $outputData = fetchAllUsers();
  echo json_encode($outputData);
}
//PUT
else if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    $updateData = json_decode(file_get_contents("php://input"), true);
    $pid= $_GET['id'] ?? null ;
    $updateuser = updateUser($updateData,$pid);
    echo $updateuser;
} 
//DELETE
else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
  $deleteData = json_decode(file_get_contents("php://input"), true);
  $pid= $_GET['id'] ?? null ;
  if($pid != null) {
    $deleteuser = deleteUserById($pid);
    echo $deleteuser;
  } else {
    echo "Invalid user id";
  }  

} 
else {
  http_response_code(405);
  echo json_encode(["error" => "Unsupported request method"]);
}

?>