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
$food_name = $_POST['food_name'] ?? '';
$description = $_POST['description'] ?? '';
$price = floatval($_POST['price'] ?? 0);

// Check if required fields are present
if (empty($food_name) || empty($price)) {
    // You can add more error handling or redirection logic here
    echo "Food name and price are required.";
    exit();
}

// Handle image upload if exists
$image_path = ''; // Default value for image

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    // Check if file type is valid
    if (in_array($imageFileType, $allowed_types)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = basename($_FILES["image"]["name"]);
        } else {
            echo "Sorry, there was an error uploading your image.";
            exit();
        }
    } else {
        echo "Invalid file type. Only JPG, JPEG, PNG & GIF are allowed.";
        exit();
    }
}

// Insert new item into the database with food_court_id
$query = "INSERT INTO food_items (food_name, description, price, stall_id, food_court_id, image_path) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssdiss", $food_name, $description, $price, $stall_id, $food_court_id, $image_path);
$stmt->execute();

// Redirect back to vendor home page
header("Location: vendor_home.php");
exit();
?>