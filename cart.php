<?php
// Include database connection file
include_once("Database.php");

// Function to fetch all carts from the database
function getAllCarts() {
    global $conn;
    $query = "SELECT * FROM cart";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Function to add a new cart to the database
function addCart($products, $quantities, $user_id) {
    global $conn;
    $products = mysqli_real_escape_string($conn, $products);
    $quantities = mysqli_real_escape_string($conn, $quantities);
    $user_id = mysqli_real_escape_string($conn, $user_id);
    
    $query = "INSERT INTO cart (products, quantities, user_id) VALUES ('$products', '$quantities', '$user_id')";
    return mysqli_query($conn, $query);
}

// Function to update an existing cart in the database
function updateCart($id, $products, $quantities, $user_id) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $products = mysqli_real_escape_string($conn, $products);
    $quantities = mysqli_real_escape_string($conn, $quantities);
    $user_id = mysqli_real_escape_string($conn, $user_id);
    
    $query = "UPDATE cart SET products='$products', quantities='$quantities', user_id='$user_id' WHERE id='$id'";
    return mysqli_query($conn, $query);
}

// Function to delete a cart from the database
function deleteCart($id) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    
    $query = "DELETE FROM cart WHERE id='$id'";
    return mysqli_query($conn, $query);
}

// Function to fetch a single cart by ID from the database
function getCartById($id) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    
    $query = "SELECT * FROM cart WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// Add CRUD operations for Comments, User, and Order entities here similarly

?>
 