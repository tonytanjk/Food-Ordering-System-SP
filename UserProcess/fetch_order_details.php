<?php
// Include common.php for database connection and common functions
include '../scripts/common.php';

// Get the order ID from the query string
$order_id = $_GET['order_id'];

// Fetch order items from the database
$query = "
    SELECT oi.quantity, fi.food_name, oi.price
    FROM order_items oi
    JOIN food_items fi ON oi.food_item_id = fi.food_item_id
    WHERE oi.order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);

// Return the order items as JSON
header('Content-Type: application/json');
echo json_encode($items);
?>