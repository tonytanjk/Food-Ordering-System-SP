<?php
// Include database connection and common functions
include '../scripts/common.php';

// Assume user_id is stored in session after login
$user_id = $_SESSION['user_id'] ?? 0;

// Fetch stall_id and food_court_id for the logged-in user
$query = "SELECT stall_id, food_court_id FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stall_id = $user['stall_id'] ?? 0;
$food_court_id = $user['food_court_id'] ?? 0;

// Get form data
$food_name = $_POST['food_name'];
$description = $_POST['description'];
$price = floatval($_POST['price']);

// Insert new item into the database with food_court_id
$query = "INSERT INTO food_items (food_name, description, price, stall_id, food_court_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssdii", $food_name, $description, $price, $stall_id, $food_court_id);
$stmt->execute();

// Redirect back to vendor home page
header("Location: vendor_home.php");
exit();
?>
