<?php

include_once("Database.php");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,  X-Requested-With');

// Function to fetch all Comments from database
function fetchAllComments() {
    global $conn;

    $sql="SELECT * FROM comments";
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

// Function to insert a new Comment to the database
function insertComment($CommentData) {
    global $conn;

    if(isset($CommentData['product_id']) && isset($CommentData['user_id']) && isset($CommentData['rating']) && isset($CommentData['image']) && isset($CommentData['text'])) {
       
        $product_id = mysqli_real_escape_string($conn, $CommentData['product_id']);
        $user_id = mysqli_real_escape_string($conn, $CommentData['user_id']);
        $rating = mysqli_real_escape_string($conn, $CommentData['rating']);
        $image = mysqli_real_escape_string($conn, $CommentData['image']);
        $text = mysqli_real_escape_string($conn, $CommentData['text']);
        
        // SQL INSERT query
        $sql = "INSERT INTO comments (product_id, user_id, rating, image, text) VALUES ('$product_id', '$user_id', '$rating', '$image', '$text')";
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        // Run the INSERT query
        if(mysqli_query($conn, $sql)) {
            $data = [
                'status' => 201,
                'message' => 'Comment data inserted Successfully',
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

// Function to update an existing Comment in the database
function updateComment($updateData,$CommentID) {
    global $conn;
    $rating = mysqli_real_escape_string($conn, $updateData['rating']);
    $image = mysqli_real_escape_string($conn, $updateData['image']);
    $text = mysqli_real_escape_string($conn, $updateData['text']);

    if($CommentID != null) {
        $sql = "UPDATE comments SET rating='$rating', text='$text', image='$image' WHERE id=$CommentID";
        // Run the UPDATE query
        if(mysqli_query($conn, $sql)) {
            $data = [
                'status' => 201,
                'message' => 'Comment data updated Successfully',
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
        return json_encode(array("message" => "Missing id of Comment you want to update", "status" => false));
    }
}

// Function to delete a Comment from the database
function deleteCommentById($cid) {
    global $conn;
    $Comment_id = mysqli_real_escape_string($conn, $cid);
    
    //Delete query 
    $sql = "DELETE FROM comments WHERE id='$Comment_id'";

    if(mysqli_query($conn, $sql)) {
        $data = [
            'status' => 201,
            'message' => 'Comment deleted Successfully',
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
