<?php
// Include database connection and common functions
include '../scripts/common.php';

// Get form data
$stall_id = intval($_POST['stall_id']);
$food_name = $_POST['food_name'];

// Delete item from the database
$query = "DELETE FROM food_items WHERE stall_id = ? AND food_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $stall_id, $food_name);
$stmt->execute();

// Redirect back to vendor home page
header("Location: vendor_home.php");
exit();
?>