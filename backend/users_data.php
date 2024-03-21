<?php
session_start();
require_once './dbconfig.php';

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    // Check the request method
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Read Database

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $queryUser = $conn->prepare("SELECT id, name, username, email, clearance FROM users WHERE id = ?");
            $queryUser->bind_param("i", $id);
            $queryUser->execute();
            $result = $queryUser->get_result();

            if ($result->num_rows > 0) {
                $users_data = $result->fetch_assoc();
                echo json_encode($users_data);
                exit();
            } else {
                // User not found
                echo json_encode(['error' => 'User not found']);
                exit();
            }
        } else if ($_SESSION["clearance"] == "SuperAdmin") {
            // Retrieve all users data
            $queryUsers = $conn->query("SELECT id, name, username, password, email, clearance FROM users");
            $users_data = array();
            while ($data = $queryUsers->fetch_assoc()) {
                //Password Hashing
                $hashedPassword = $data['password'];
                

                $user = $data;
                
                $user['password'] = $hashedPassword;
                
                $users_data[] = $user;
            }
            echo json_encode($users_data);
            exit();
        } else {
            // Retrieve all users data
            $queryUsers = $conn->prepare("SELECT id, name, username, email, clearance FROM users WHERE clearance = ?");
            $clearance = "User";
            $queryUsers->bind_param("s", $clearance);
            $queryUsers->execute();
            $result = $queryUsers->get_result();

            $users_data = array();
            while ($data = $result->fetch_assoc()) {
                $users_data[] = $data;
            }
            echo json_encode($users_data);
            exit();
        }
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $error = array('error' => false);

        $action = $_POST['action'];

        // Validate action
        if (!in_array($action, ['update', 'delete'])) {
            echo json_encode(['error' => 'Invalid action']);
            exit();
        }

        if ($action == 'update') {
            $name = $_POST['name'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $id = $_POST['id'];
            // Validate input fields
            if (empty($name)) {
                $error['error'] = true;
                $error['name'] = "Name cannot be empty";
            }
            if (empty($username)) {
                $error['error'] = true;
                $error['username'] = "Username cannot be empty";
            }
            if (empty($email)) {
                $error['error'] = true;
                $error['email'] = "Email cannot be empty";
            }

            if ($error['error']) {
                echo json_encode($error);
                exit();
            }

            // Data validated
            if ($_SESSION["clearance"] == "SuperAdmin") {
                $clearance = $_POST['clearance'];
                $queryUpdate = $conn->prepare("UPDATE users SET name = ?, username = ?, email = ?, clearance = ? WHERE id = ?");
                $queryUpdate->bind_param("ssssi", $name, $username, $email, $clearance, $id);
            } else if($_SESSION["clearance"] == "Admin"){
                $queryUpdate = $conn->prepare("UPDATE users SET name = ?, username = ?, email = ? WHERE id = ?");
                $queryUpdate->bind_param("sssi", $name, $username, $email, $id);
            }
            if ($queryUpdate->execute()) {
                $users_data['status'] = "OK";
                $users_data['title'] = "User Update";
                $users_data['msg'] = "User data has been updated";
            } else {
                $err = $queryUpdate->error;
                $users_data['status'] = 'error';
                $users_data['title'] = "Error Occurred While Updating Users";
                $users_data['msg'] = "Failed to update: $err";
            }
        } else if ($action == 'delete') {
            $id = $_POST['id'];
            $queryDelete = $conn->prepare("DELETE FROM users WHERE id = ?");
            $queryDelete->bind_param("i", $id);

            if ($queryDelete->execute()) {
                $users_data['status'] = "OK";
                $users_data['title'] = "User Deleted";
                $users_data['msg'] = "User data has been deleted";
            } else {
                $err = $queryDelete->error;
                $users_data['status'] = 'error';
                $users_data['title'] = "Error Occurred While Deleting User";
                $users_data['msg'] = "Failed to delete: $err";
            }
        }
        echo json_encode($users_data);
        $conn->close();
        exit();
    }
} else {
    header('Location: ../login.php');
}
?>
