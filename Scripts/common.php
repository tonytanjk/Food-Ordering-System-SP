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

// Fetch total sales amount
function getTotalSales($conn) {
    $query = "SELECT SUM(total_price) AS total_sales FROM orders";
    $result = $conn->query($query);
    return $result->fetch_assoc()['total_sales'] ?? 0.00;
}

// Fetch total orders count
function getTotalOrders($conn) {
    $query = "SELECT COUNT(*) AS total_orders FROM orders";
    $result = $conn->query($query);
    return $result->fetch_assoc()['total_orders'] ?? 0;
}

// Calculate average order value
function getAverageOrderValue($conn) {
    $totalSales = getTotalSales($conn);
    $totalOrders = getTotalOrders($conn);
    return $totalOrders > 0 ? $totalSales / $totalOrders : 0.00;
}

// Fetch sales trends by date (last N days)
function getSalesTrends($days, $conn) {
    $query = "
        SELECT DATE(order_date) AS order_date, SUM(total_price) AS daily_sales 
        FROM orders 
        WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
        GROUP BY DATE(order_date) 
        ORDER BY order_date ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $days);
    $stmt->execute();
    $result = $stmt->get_result();
    $trends = [];
    while ($row = $result->fetch_assoc()) {
        $trends[] = $row;
    }
    return $trends;
}

// Example usage for sales metrics (For Vendor)
$accountBalance = getAccountBalance($userId, $conn);
$totalSales = getTotalSales($conn);
$totalOrders = getTotalOrders($conn);
$averageOrderValue = getAverageOrderValue($conn);
$salesTrends = getSalesTrends(7, $conn); // Last 7 days

// Fetch food court ID and food items for a specific court or stall (For FC1 - FC6)
$food_court_id = isset($_GET['food_court_id']) ? intval($_GET['food_court_id']) : 4;
$stall_id = isset($_GET['stall_id']) ? intval($_GET['stall_id']) : null;
$stall_result = $food_court_id ? getFoodStalls($food_court_id, $conn) : null;
$food_result = $stall_id ? getFoodItems($stall_id, $conn) : null;


?>
