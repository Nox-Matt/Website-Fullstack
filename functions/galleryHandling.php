<?php
require_once '../backend/dbconfig.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["titleGallery"];
    $filecount = count($_FILES['gallery']['name']);

    for ($i = 0; $i < $filecount; $i++) {
        $image_name = $_FILES['gallery']['name'][$i];
        $image_tmp = $_FILES['gallery']['tmp_name'][$i];
        $image_size = $_FILES['gallery']['size'][$i];
        $directory = '../galleryImg/';
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $allowed_mime_types = ['image/jpeg', 'image/png'];

        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $file_mime_type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $image_tmp);

        if (!in_array($file_extension, $allowed_extensions) || !in_array($file_mime_type, $allowed_mime_types)) {
            echo json_encode(array("message" => "Error: Only JPG and PNG files are allowed"));
            exit;
        }

        $max_size = 20 * 1024 * 1024; // 20 MB
        if ($image_size > $max_size) {
            echo json_encode(array("message" => "Error: File size is too large. Exceeds the maximum limit of 20 MB."));
            exit;
        }

        $unique_filename = uniqid() . '_' . $image_name;
        $uploadpath = $directory . $unique_filename;

        if (move_uploaded_file($image_tmp, $uploadpath)) {

            $query = "INSERT INTO gallery (img, tittle) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $uploadpath, $title);
            if ($stmt->execute()) {
                $response["message"] = "Content Uploaded Successfully.";
                http_response_code(200);
                echo json_encode($response);
            } else {
                $response["message"] = "Error: Failed to insert data into the database.";
                echo json_encode($response);
            }
    
            $stmt->close();
        } else {
            $response["message"] = "Error: Failed to move the uploaded file.";
            echo json_encode($response);
        }
    }
}
?>
