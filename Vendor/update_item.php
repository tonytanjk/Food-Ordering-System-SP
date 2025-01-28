<?php
// Include database connection and common functions
include '../scripts/common.php';
    // Profile picture upload logic
    $profile_picture_path = $user['profile_picture']; // Default to current profile picture
    if (!empty($profile_picture['name'])) {
        $upload_dir = '../uploads/';
        $profile_picture_path = $upload_dir . basename($profile_picture['name']);
        move_uploaded_file($profile_picture['tmp_name'], $profile_picture_path);
    }
// Get form data
$item_id = intval($_POST['item_id']);
$food_name = $_POST['food_name'];
$description = $_POST['description'];
$price = floatval($_POST['price']);

// Update item in the database
$query = "UPDATE food_items SET food_name = ?, description = ?, price = ? WHERE food_item_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssdi", $food_name, $description, $price, $item_id);
$stmt->execute();

// Redirect back to vendor home page
header("Location: vendor_home.php");
exit();
?>