<?php
session_start();

// Database connection details
$host = 'localhost';  // Change to your database host
$dbname = 'projectcsad';  // Change to your database name
$username = 'root';  // Change to your database username
$password = '';  // Change to your database password

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>