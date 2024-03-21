<?php
require_once 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Read Database
    // Retrieve all news data
    $queryNews = $conn->query("SELECT id, title, image, content FROM news");
    if (!$queryNews) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Failed to retrieve news data']);
        exit();
    }
    $newsData = array();
    while ($data = $queryNews->fetch_assoc()) {
        $newsData[] = $data;
    }

    header('Content-Type: application/json');
    echo json_encode($newsData);
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = array('error' => false);
    $action = $_POST['action'];

    // Validate action
    if (!in_array($action, ['update', 'delete'])) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid action']);
        exit();
    }

    if ($action === 'update') {
        // Validate input fields
        $title = $_POST['title'];
        $content = $_POST['content'];
        $id = $_POST['id'];

        if (empty($title) || empty($content)) {
            $error['error'] = true;
            $error['message'] = "Title and content cannot be empty";
        }

        if ($error['error']) {
            header('Content-Type: application/json');
            echo json_encode($error);
            exit();
        }

        // Data validated
        $queryUpdate = $conn->prepare("UPDATE news SET title=?, content=? WHERE id=?");
        $queryUpdate->bind_param("ssi", $title, $content, $id);
        $queryUpdate->execute();

        $response = array();

        if ($queryUpdate->affected_rows > 0) {
            $response['status'] = "OK";
            $response['title'] = "News Update";
            $response['message'] = "News data has been updated";
        } else {
            $err = $queryUpdate->error;
            $response['status'] = 'error';
            $response['title'] = "Error Occurred While Updating News";
            $response['message'] = "Failed to update: $err";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } elseif ($action === 'delete') {
        //Image Delete lmao
        $id = $_POST['id'];
        $imagePath = $conn->prepare("SELECT image FROM news WHERE id=?");
        $imagePath->bind_param("i", $id);
        $imagePath->execute();
        $imagePath->bind_result($delImg);
        $imagePath->fetch();
        $imagePath->close();
        //Query Delete
        $queryDelete = $conn->prepare("DELETE FROM news WHERE id=?");
        $queryDelete->bind_param("i", $id);
        $response = array();
        unlink($delImg);

        if ($queryDelete->execute()) {
            $response['status'] = "OK";
            $response['title'] = "News Deleted";
            $response['message'] = "News has been deleted";
        } else {
            $err = $queryDelete->error;
            $response['status'] = "error";
            $response['title'] = "News Not Deleted";
            $response['message'] = "Failed to delete news: " . $err;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } elseif ($action === 'getById') {
        $id = $_POST['id'];
        $queryGetById = $conn->prepare("SELECT id, title, image, content FROM news WHERE id=?");
        $queryGetById->bind_param("i", $id);
        if ($queryGetById->execute()) {
            $result = $queryGetById->get_result();
            $newsData = $result->fetch_assoc();

            header('Content-Type: application/json');
            echo json_encode($newsData);
            exit();
        } 
} else {
    header('Location: ../frontend/login.php');
    exit();
}
}
?>
