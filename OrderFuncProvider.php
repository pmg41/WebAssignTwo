<?php

include_once("Database.php");

header("content-type: application/json"); 
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,  X-Requested-With');



// Function to fetch all Orders from database
function fetchAllOrders() {
    global $conn;
    $sql="SELECT * FROM orders";
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

// Function to insert a new Order to the database
function insertOrder($OrderData) {
    global $conn;
    if(isset($OrderData['user_id']) && isset($OrderData['total_amount'])) {
        $userId = $OrderData["user_id"];
        $totalAmount = $OrderData["total_amount"];
        // SQL INSERT query
        $sql = "INSERT INTO orders (user_id, total_amount) VALUES ('$userId', '$totalAmount')";
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        // Run the INSERT query
        if(mysqli_query($conn, $sql)) {

            $data = [
                'status' => 201,
                'message' => 'Order data inserted Successfully',
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
        return json_encode(array("message" => "Missing required parameters", "status" => false));
    }
}

// Function to update an existing Order in the database
function updateOrder($updateData,$OrderID) {
    global $conn;
    $userId = $updateData["user_id"];
    $totalAmount = $updateData["total_amount"];
    if($OrderID != null) {
        $sql = "UPDATE orders SET user_id='$userId', total_amount='$totalAmount' WHERE id=$OrderID";
        // Run the UPDATE query
        if(mysqli_query($conn, $sql)) {
            $data = [
                'status' => 201,
                'message' => 'Order data updated Successfully',
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
        return json_encode(array("message" => "Missing id of Order you want to update", "status" => false));
    }
}

// Function to delete a Order from the database
function deleteOrderById($oid) {
    global $conn;
    $Order_id = mysqli_real_escape_string($conn, $oid);
    
    //Delete query 
    $sql = "DELETE FROM Orders WHERE id='$Order_id'";

    if(mysqli_query($conn, $sql)) {
        $data = [
            'status' => 201,
            'message' => 'Order deleted Successfully',
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
