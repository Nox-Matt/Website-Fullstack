<?php
require_once './dbconfig.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: ../login.php');
    exit();
}

// Check the request method
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Read Database
    // Retrieve blog data
    $queryUser = $conn->prepare("SELECT id, image, content FROM content WHERE user_id = ?");
    $queryUser->bind_param("i", $_SESSION['id']);
    $queryUser->execute();
    $result = $queryUser->get_result();
    $blog_data = array();
    while ($data = $result->fetch_assoc()) {
        $blog_data[] = $data;
    }

    // Send the blog data as JSON response
    header('Content-Type: application/json');
    echo json_encode($blog_data);
    exit();
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = array('error' => false);
    $action = $_POST['action'];

    // Validate action
    if (!in_array($action, ['update', 'delete'])) {
        echo json_encode(['error' == 'Invalid action']);
        exit();
    }

    if ($action == 'update') {
        // Validate input fields
        $content = $_POST['content'];
        $id = $_POST['id'];

        if (empty($content)) {
            $error['error'] = true;
            $error['content'] = "Content cannot be empty";
        }

        if ($error['error']) {
            echo json_encode($error);
            exit();
        }

        // Data validated
        $queryUpdate = $conn->prepare("UPDATE content SET content = ? WHERE id = ? AND user_id = ?");
        $queryUpdate->bind_param("sii", $content, $id, $_SESSION['id']);
        $queryUpdate->execute();

        $blog_data = array();

        if ($queryUpdate->affected_rows > 0) {
            $blog_data['status'] = "OK";
            $blog_data['title'] = "Blog Update";
            $blog_data['msg'] = "Blog data has been updated";
        } else {
            $err = $queryUpdate->error;
            $blog_data['status'] = 'error';
            $blog_data['title'] = "Error Occurred While Updating Blog";
            $blog_data['msg'] = "Failed to update: $err";
        }
    } else if ($action == 'delete') {
        $id = $_POST['id'];
        $queryDelete = $conn->prepare("DELETE FROM content WHERE id=?");
        $queryDelete->bind_param("i", $id);

        if ($queryDelete->execute()) {
            $blog_data['status'] = "OK";
            $blog_data['title'] = "Blog deleted";
            $blog_data['msg'] = "Blog has been deleted";
        } else {
            $err = $queryDelete->error;
            $blog_data['status'] = "error";
            $blog_data['title'] = "Blog not deleted";
            $blog_data['msg'] = "Failed to delete blog: " . $err;
        }
    }
    $conn->close();
    exit();
}

?>
