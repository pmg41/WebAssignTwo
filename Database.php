<?php
try {
    $conn = new mysqli('localhost', 'root', '', 'rest_api_demo');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        echo "Connection Test Successfully";
    }
} catch (Exception $e) {
    throw new Exception($e->getMessage());
}
?>