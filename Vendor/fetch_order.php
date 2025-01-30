<?php
include '../scripts/common.php';

header('Content-Type: application/json');

$order_id = $_GET['order_id'] ?? 0;

// Fetch order details
$query = "
    SELECT 
        o.order_id, 
        o.tracking_id, 
        u.username, 
        o.total_amount, 
        o.payment_method, 
        o.order_date, 
        GROUP_CONCAT(CONCAT(fi.food_name, ' x', oi.quantity, ' ($', oi.price, ')') SEPARATOR '<br>') AS order_details
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN food_items fi ON oi.food_item_id = fi.food_item_id
    WHERE o.order_id = ?
    GROUP BY o.order_id;";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if ($order) {
    echo json_encode(['success' => true] + $order);
} else {
    echo json_encode(['success' => false, 'message' => 'Order not found']);
}
?>