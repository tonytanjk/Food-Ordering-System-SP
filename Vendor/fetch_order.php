<?php
include '../scripts/common.php';
header('Content-Type: application/json');

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid order ID']);
    exit();
}

// Fetch stall_id and food_court_id for the logged-in vendor
$user_id = $_SESSION['user_id'] ?? 0;

$query = "SELECT stall_id, food_court_id FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stall_id = $user['stall_id'] ?? 0;
$food_court_id = $user['food_court_id'] ?? 0;

// Fetch order details ensuring it's from the correct stall and food court
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
    JOIN food_stalls fs ON fi.stall_id = fs.stall_id
    WHERE o.order_id = ? AND fs.stall_id = ? AND fs.food_court_id = ?
    GROUP BY o.order_id;
";

$stmt = $conn->prepare($query);
$stmt->bind_param('iii', $order_id, $stall_id, $food_court_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if ($order) {
    echo json_encode(['success' => true] + $order);
} else {
    echo json_encode(['success' => false, 'message' => 'Order not found or unauthorized access']);
}
?>
