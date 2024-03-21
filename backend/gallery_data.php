<?php
require_once '../backend/dbconfig.php';
session_start();

if (!isset($_SESSION['id'])) {
    header('Location:../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['action'])) {
        $id = $_GET['id'];

        // Prepare statment
        $queryGallery = $conn->prepare("SELECT img, tittle FROM gallery WHERE id = ?");
        $queryGallery->bind_param("i", $id);
        $queryGallery->execute();

        $result = $queryGallery->get_result();

        if ($result->num_rows > 0) {
            $galleryData = $result->fetch_assoc();
        } else {
            echo "Gallery item not found.";
            exit();
        }
    } else {
        // Retrieve all gallery data
        // Prepare the statement
        $queryGallery = $conn->prepare("SELECT id, img, tittle FROM gallery");

        $queryGallery->execute();
        $result = $queryGallery->get_result();

        $galleryData = array();
        while ($data = $result->fetch_assoc()) {
            $galleryData[] = $data;
        }
    }
    $jsonFile = fopen('./gallery.json', 'w');
    fwrite($jsonFile, json_encode($galleryData));
    fclose($jsonFile);
    header('Location: gallery.json');
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == "update") {
            // Update gallery item
            if (isset($_POST['galleryId']) && isset($_POST['titleGallery'])) {
                $id = $_POST['galleryId'];
                $title = $_POST['titleGallery'];

                if (isset($_FILES['imageGallery']) && $_FILES['imageGallery']['error'] === UPLOAD_ERR_OK) {
                    $image_name = $_FILES['imageGallery']['name'];
                    $image_tmp = $_FILES['imageGallery']['tmp_name'];
                    $image_size = $_FILES['imageGallery']['size'];
                    $directory = '../galleryImg/';
                    $allowed_extensions = ['jpg', 'jpeg', 'png'];
                    $allowed_mime_types = ['image/jpeg', 'image/png'];

                    $extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
                    $image_mime = mime_content_type($image_tmp);

                    if (!in_array($extension, $allowed_extensions) || !in_array($image_mime, $allowed_mime_types)) {
                        echo json_encode(array("status" => "ERROR", "message" => "Invalid image format. Only JPG, JPEG, and PNG images are allowed."));
                        exit();
                    }

                    // Generate a unique filename for the uploaded image
                    $unique_filename = uniqid() . '_' . $image_name;
                    $uploadpath = $directory . $unique_filename;

                    // Delete the old image 
                    $queryImage = $conn->prepare("SELECT img FROM gallery WHERE id = ?");
                    $queryImage->bind_param("i", $id);
                    $queryImage->execute();
                    $result = $queryImage->get_result();

                    if ($result->num_rows > 0) {
                        $imageData = $result->fetch_assoc();
                        $oldImagePath = $imageData['img'];

                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    if (move_uploaded_file($image_tmp, $uploadpath)) {
                        // Prepare the statement 
                        $updateGallery = $conn->prepare("UPDATE gallery SET tittle = ?, img = ? WHERE id = ?");
                        $updateGallery->bind_param("ssi", $title, $uploadpath, $id);

                        if ($updateGallery->execute()) {
                            echo json_encode(array("status" => "OK", "message" => "Gallery item updated successfully", "title" => $title));
                        } else {
                            echo json_encode(array("status" => "ERROR", "message" => "Failed to update gallery item"));
                        }
                        exit();
                    } else {
                        echo json_encode(array("status" => "ERROR", "message" => "Failed to move the uploaded file."));
                        exit;
                    }
                } else {
                    // Yitle only
                    $updateGallery = $conn->prepare("UPDATE gallery SET tittle = ? WHERE id = ?");
                    $updateGallery->bind_param("si", $title, $id);

                    if ($updateGallery->execute()) {
                        echo json_encode(array("status" => "OK", "message" => "Gallery item updated successfully", "title" => $title));
                    } else {
                        echo json_encode(array("status" => "ERROR", "message" => "Failed to update gallery item"));
                    }
                    exit();
                }
            }
        } elseif ($action == "delete") {
            // Delete gallery item
            if (isset($_POST['id'])) {
                $id = $_POST['id'];

                // Prepare the statement to get the image path
                $ImagePath = $conn->prepare("SELECT img FROM gallery WHERE id = ?");
                $ImagePath->bind_param("i", $id);
                $ImagePath->execute();
                $result = $ImagePath->get_result();

                if ($result->num_rows > 0) {
                    $imageData = $result->fetch_assoc();
                    $imagePath = $imageData['img'];

                    unlink($imagePath);
                }

                $deleteGallery = $conn->prepare("DELETE FROM gallery WHERE id = ?");
                $deleteGallery->bind_param("i", $id);

                if ($deleteGallery->execute()) {
                    // Delete successful
                    echo json_encode(array("status" => "OK", "message" => "Gallery item deleted successfully"));
                } else {
                    // Delete failed
                    echo json_encode(array("status" => "ERROR", "message" => "Failed to delete gallery item"));
                }
                exit();
            }
        }
    }
} else {
    header('Location: ../frontend/login.php');
    exit();
}
?>
