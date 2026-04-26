<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "sql213.infinityfree.com";
$user = "if0_41741164";
$pass = "CReH0w8W8ZB";
$db   = "if0_41741164_smart_agriculture";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

echo "Database Connected Successfully";
?>