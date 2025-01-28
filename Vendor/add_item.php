<?php
// Include database connection and common functions
include '../scripts/common.php';
// Get form data
$stall_id = intval($_POST['stall_id']);
$food_name = $_POST['food_name'];
$description = $_POST['description'];
$price = floatval($_POST['price']);

// Insert new item into the database
$query = "INSERT INTO food_items (food_name, description, price, stall_id) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssdi", $food_name, $description, $price, $stall_id);
$stmt->execute();


// Redirect back to vendor home page
header("Location: vendor_home.php");
exit();
?>