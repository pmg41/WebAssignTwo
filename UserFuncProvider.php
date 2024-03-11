<?php

include_once("Database.php");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,  X-Requested-With');

// Function to fetch all Users from database
function fetchAllUsers() {
    global $conn;

    $sql="SELECT * FROM users";
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

// Function to insert a new User to the database
function insertUser($UserData) {
    global $conn;
    if(isset($UserData['email']) && isset($UserData['password']) && isset($UserData['username']) && isset($UserData['purchase_history']) && isset($UserData['shipping_address'])) {
        echo "all data is correct";
        $email = mysqli_real_escape_string($conn, $UserData['email']);
        $username =  mysqli_real_escape_string($conn,  $UserData['username']);
        $password = mysqli_real_escape_string($conn, $UserData['password']);
        $purchase_history = mysqli_real_escape_string($conn, $UserData['purchase_history']);
        $shipping_address = mysqli_real_escape_string($conn, $UserData['shipping_address']);
        
        // SQL INSERT query
        $sql = "INSERT INTO users (email, password, username, purchase_history, shipping_address) VALUES ('$email', '$password', '$username', '$purchase_history', '$shipping_address')";
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        // Run the INSERT query
        if(mysqli_query($conn, $sql)) {

            $data = [
                'status' => 201,
                'message' => 'User data inserted Successfully',
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

// Function to update an existing User in the database
function updateUser($updateData,$UserID) {
    global $conn;
    $email = mysqli_real_escape_string($conn, $updateData['email']);
    $username =  mysqli_real_escape_string($conn,  $updateData['username']);
    $password = mysqli_real_escape_string($conn, $updateData['password']);
    $purchase_history = mysqli_real_escape_string($conn, $updateData['purchase_history']);
    $shipping_address = mysqli_real_escape_string($conn, $updateData['shipping_address']);

    if($UserID != null) {
        $sql = "UPDATE users  SET email='$email', password='$password', username='$username', purchase_history='$purchase_history', shipping_address='$shipping_address' WHERE id='$UserID'";
        // Run the UPDATE query
        if(mysqli_query($conn, $sql)) {
            $data = [
                'status' => 201,
                'message' => 'User data updated Successfully',
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
        return json_encode(array("message" => "Missing id of User you want to update", "status" => false));
    }
}

// Function to delete a User from the database
function deleteUserById($uid) {
    global $conn;
    $User_id = mysqli_real_escape_string($conn, $uid);
    
    //Delete query 
    $sql = "DELETE FROM users WHERE id='$User_id'";

    if(mysqli_query($conn, $sql)) {
        $data = [
            'status' => 201,
            'message' => 'User deleted Successfully',
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
