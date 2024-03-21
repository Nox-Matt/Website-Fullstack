<?php
require './function.php';
$_SESSION = [];
session_destroy();
header("location: ../frontend/login.php");
?>