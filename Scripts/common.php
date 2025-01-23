<?php

// Include database connection
include_once '../db_connection.php';

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: ../UserProcess/login.php");
    exit();
}

// Get user ID from session
$userId = $_SESSION['user_id'];

// Fetch user account balance
function getAccountBalance($userId, $conn) {
    $query = "SELECT account_balance FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['account_balance'];
    }
    return 0.00; // Default balance if not found
}
$accountBalance = getAccountBalance($userId, $conn);

// Fetch food stalls for a given food court
function getFoodStalls($foodCourtId, $conn) {
    $query = "SELECT * FROM food_stalls WHERE food_court_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $foodCourtId);
    $stmt->execute();
    return $stmt->get_result();
}

// Fetch food items for a given stall
function getFoodItems($stallId, $conn) {
    $query = "SELECT * FROM food_items WHERE stall_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $stallId);
    $stmt->execute();
    return $stmt->get_result();
}

// Get the current food court ID from the URL or default to 4
$food_court_id = isset($_GET['food_court_id']) ? intval($_GET['food_court_id']) : 4;

// Check if a specific food stall is selected
$stall_id = isset($_GET['stall_id']) ? intval($_GET['stall_id']) : null;

// Fetch food stalls and items as needed
$stall_result = $food_court_id ? getFoodStalls($food_court_id, $conn) : null;
$food_result = $stall_id ? getFoodItems($stall_id, $conn) : null;
?>
