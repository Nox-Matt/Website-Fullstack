<?php
//Connection [one time connection || Don't use include config]
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);
session_start();
$current_url = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);
if ($current_url == __DIR__ . 'frontend/indexUser.php') {
    require_once '../dbconfig.php';
} else {
    require_once '../backend/dbconfig.php';
}
if (isset($_POST["action"])) {
    if ($_POST["action"] == "register") {
        register();
    } elseif ($_POST["action"] == "login") {
        login();
    } else {
        echo "Cannot Login";
    }
}

function register()
{
    global $conn;

    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $passwordConfirm = $_POST["passwordRepeat"];
    $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

    // Validate Email Format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid Email Format, Please Input another one";
        exit;
    }

    // Form Checking
    if (preg_match($password_regex, $password) === 0) {
        echo "Use a stronger password";
        exit;
    }

    if (empty($name) || empty($username) || empty($password) || empty($email) || empty($passwordConfirm)) {
        echo "Please Fill Out The Form";
        exit;
    } elseif (empty($username)) {
        echo "Please fill out your username";
        exit;
    } elseif (empty($password)) {
        echo "Please fill out the password";
        exit;
    } elseif (empty($name)) {
        echo "Please fill your name";
        exit;
    } elseif (empty($email)) {
        echo "Please fill your email";
        exit;
    }

    // Password Confirmation
    if ($password !== $passwordConfirm) {
        echo "Password Does Not Match, Try Again";
        exit;
    }

    // Username checking
    $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    if (count($result) > 0) {
        echo "Username has already been taken";
        exit;
    }

    // Password Hashing
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    // Insert Into
    $stmt = $conn->prepare("INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $username, $hashed_pass);
    if ($stmt->execute()) {
        echo "Registration Successful";
        header('Location: ../login.php');
    } else {
        echo "Error: Registration Failed";
    }
    exit;
}

function login()
{
    global $conn;
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stripedUsername = stripslashes($username);
    $stripedPassword = stripslashes($password);

    $stmt = $conn->prepare("SELECT id, password, username, clearance FROM users WHERE username = ?");
    $stmt->bind_param("s", $stripedUsername);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if (count($result) > 0) {
        $row = $result[0];
        $hash = $row['password'];
        if (password_verify($stripedPassword, $hash)) {
            echo "Login Successful";
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            $_SESSION["clearance"] = $row["clearance"];
        } else {
            echo "Wrong password!";
        }
    } else {
        echo "User Is Not Registered";
    }
    $stmt->close();
    $conn->close();
}