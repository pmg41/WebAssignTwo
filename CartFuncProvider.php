<?php

include_once("Database.php");

header("content-type: application/json"); 
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,  X-Requested-With');



// Function to fetch all CartData from database
function fetchAllCarts() {
    global $conn;
    $sql="SELECT * FROM cart";
    $result=mysqli_query($conn,$sql) or die("SQL Query Failed");
    $output = [];
    if(mysqli_num_rows($result) > 0){
        $output=mysqli_fetch_all($result,MYSQLI_ASSOC);
        echo json_encode($output);
    }else{
        echo json_encode(array("message"=> "No Records Found","status"=> FALSE));
    }
    return $output;
}

// Function to insert a new Cart data into the database
function insertCart($CartData) {
    global $conn;
    if(isset($CartData['product_id']) && isset($CartData['quantity'])  && isset($CartData['user_id'])) {
    
    $product_id = $CartData["product_id"];
    $quantity = $CartData["quantity"];
    $user_id = $CartData["user_id"];

    // Validate input data
    $product_id = mysqli_real_escape_string($conn, $product_id);
    $quantity = mysqli_real_escape_string($conn, $quantity);
    $user_id = mysqli_real_escape_string($conn, $user_id);

    // INSERT query
    $sql = "INSERT INTO cart (product_id, quantity, user_id) VALUES ('$product_id', '$quantity', '$user_id')";

        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        // Run the INSERT query
        if(mysqli_query($conn, $sql)) {

            $data = [
                'status' => 201,
                'message' => 'Cart data inserted Successfully',
            ];
            header("HTTP/1.1 201 Created");
            header('Content-Type: application/json');
            // echo json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.1 500 Internal Server Error");
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    } else {
        return json_encode(array("message" => "Missing required parameters", "status" => false));
    }
}

// Function to update an existing Cart in the database
function updateCart($updateData,$CartID) {
    global $conn;

    $product_id = $updateData["product_id"];
    $quantity = $updateData["quantity"];
    $user_id = $updateData["user_id"];

    //validate input data
    $product_id = mysqli_real_escape_string($conn, $product_id);
    $quantity = mysqli_real_escape_string($conn, $quantity);
    $user_id = mysqli_real_escape_string($conn, $user_id);

    if($CartID != null) {
        $sql = "UPDATE cart SET quantity = '$quantity', product_id = '$product_id', user_id = '$user_id' WHERE id ='$CartID'";
        // Run the UPDATE query
        if(mysqli_query($conn, $sql)) {
            $data = [
                'status' => 201,
                'message' => 'Cart data updated Successfully',
            ];
            header("HTTP/1.1 201 Created");
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.1 500 Internal Server Error");
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    } else {
        return json_encode(array("message" => "Missing id of Cart you want to update", "status" => false));
    }
}

// Function to delete a Cart from the database
function deleteCartById($cid) {
    global $conn;
    $Cart_id = mysqli_real_escape_string($conn, $cid);
    
    //Delete query 
    $sql = "DELETE FROM cart WHERE id='$Cart_id'";

    if(mysqli_query($conn, $sql)) {
        $data = [
            'status' => 201,
            'message' => 'Cart deleted Successfully',
        ];
        header("HTTP/1.1 201 Created");
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.1 500 Internal Server Error");
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}

?>
