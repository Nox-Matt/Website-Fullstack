<?php
require_once '../backend/dbconfig.php';
session_start();

if (!isset($_SESSION['id'])) {
    header('location:../login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Read Database
    // Retrieve all blog data
    $queryBlogs = $conn->query("SELECT image, content FROM content");
    $blogs_data = array();
    while ($data = $queryBlogs->fetch_assoc()) {
        $blogs_data[] = $data;
    }

    $jsonData = json_encode($blogs_data);

    // Save JSON data to a file
    $file = fopen('content.json', 'w');
    fwrite($file, $jsonData);
    fclose($file);

    exit();
} else {
    header('Location: ../frontend/login.php');
}
?>
