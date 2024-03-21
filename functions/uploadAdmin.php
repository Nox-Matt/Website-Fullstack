<?php
require_once '../backend/dbconfig.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Content writing
    $news = $_POST["news"];
    $formattedContent = nl2br($news);
    $title = $_POST["title"];
    // File Upload
    $image_name = $_FILES['pict']['name'];
    $image_tmp = $_FILES['pict']['tmp_name'];
    $image_size = $_FILES['pict']['size'];
    $directory = '../newsImg/';
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $allowed_mime_types = ['image/jpeg', 'image/png'];

    $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $file_mime_type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $image_tmp);

    if (!in_array($file_extension, $allowed_extensions) || !in_array($file_mime_type, $allowed_mime_types)) {
        echo "Error: Only JPG and PNG files are allowed";
        exit;
    }

    // File Size Limit
    $max_size = 20 * 1024 * 1024; // 20 MB
    if ($image_size > $max_size) {
        echo "Error: File size is too large. Exceeds the maximum limit of 20 MB.";
        exit;
    }

    // Generate Unique Filename
    $unique_filename = uniqid() . '_' . $image_name;
    $uploadpath = $directory . $unique_filename;

    // Move the Uploaded File
    if (move_uploaded_file($image_tmp, $uploadpath)) {

        // ID Admin
        $admin_id = $_SESSION["id"];

        // Database Insertion
        $query = "INSERT INTO news (admin_id, title, image, content) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isss", $admin_id, $title, $uploadpath, $formattedContent);

        if ($stmt->execute()) {
            $response = array("message" => "Content Uploaded Successfully.");
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode($response);
        } else {
            echo "Error: Failed to insert data into the database.";
        }

        $stmt->close();
    } else {
        echo "Error: Failed to move the uploaded file.";
    }
}
?>
