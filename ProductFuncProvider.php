<?php

include_once("Database.php");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,  X-Requested-With');

// Function to fetch all products from database
function fetchAllProducts() {
    global $conn;

    $sql="SELECT * FROM products";
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

// Function to insert a new product to the database
function insertProduct($productData) {
    global $conn;

    if(isset($productData['description']) && isset($productData['image']) && isset($productData['pricing']) && isset($productData['shipping_cost'])) {
        echo "all data is correct";
        $description = mysqli_real_escape_string($conn, $productData['description']);
        $image = mysqli_real_escape_string($conn, $productData['image']);
        $pricing = mysqli_real_escape_string($conn, $productData['pricing']);
        $shipping_cost = mysqli_real_escape_string($conn, $productData['shipping_cost']);
        
        // SQL INSERT query
        $sql = "INSERT INTO products(description, image, pricing, shipping_cost) VALUES ('$description', '$image', '$pricing', '$shipping_cost')";
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        // Run the INSERT query
        if(mysqli_query($conn, $sql)) {

            $data = [
                'status' => 201,
                'message' => 'Product data inserted Successfully',
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

// Function to update an existing product in the database
function updateProduct($updateData,$productID) {
    global $conn;
    $description = mysqli_real_escape_string($conn, $updateData['description']);
    $image = mysqli_real_escape_string($conn, $updateData['image']);
    $pricing = mysqli_real_escape_string($conn, $updateData['pricing']);
    $shipping_cost = mysqli_real_escape_string($conn, $updateData['shipping_cost']);

    if($productID != null) {
        $sql = "UPDATE products SET description='$description', image='$image', pricing='$pricing', shipping_cost='$shipping_cost' WHERE id='$productID'";
        // Run the UPDATE query
        if(mysqli_query($conn, $sql)) {
            $data = [
                'status' => 201,
                'message' => 'Product data updated Successfully',
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
        return json_encode(array("message" => "Missing id of product you want to update", "status" => false));
    }
}

// Function to delete a product from the database
function deleteProductById($pid) {
    global $conn;
    $product_id = mysqli_real_escape_string($conn, $pid);
    
    //Delete query 
    $sql = "DELETE FROM products WHERE id='$product_id'";

    if(mysqli_query($conn, $sql)) {
        $data = [
            'status' => 201,
            'message' => 'Product deleted Successfully',
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
