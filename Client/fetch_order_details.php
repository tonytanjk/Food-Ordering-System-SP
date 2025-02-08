<?php
// Include common.php for database connection and common functions
include '../scripts/common.php';

// Get the order ID from the query string
$order_id = $_GET['order_id'] ?? null;

// Validate the order ID
if (!filter_var($order_id, FILTER_VALIDATE_INT)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid order ID']);
    exit;
}

// Fetch order items and cancellation reason (if any)
$query = "
    SELECT oi.quantity, fi.food_name, oi.price, ord.status, ord.reason, fi.food_court_id, fi.stall_id
    FROM order_items oi
    JOIN food_items fi ON oi.food_item_id = fi.food_item_id
    JOIN orders ord ON oi.order_id = ord.order_id
    WHERE oi.order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);

if (!$stmt->execute()) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database query failed']);
    exit;
}

$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);

// Check if any order items are found
if ($result->num_rows > 0) {
    // Fetch the cancellation reason and include it in the response
    $order_status = $items[0]['status'];
    $reason = $order_status === 'Cancelled' ? $items[0]['reason'] : null;
    $foodCourtId = $items[0]['food_court_id'];
    $stallId = $items[0]['stall_id'];

    // Return the order items along with the status and cancellation reason (if any)
    $response = [
        'status' => $order_status,
        'reason' => $reason,
        'food_court_id' => $foodCourtId,
        'stall_id' => $stallId,
        'items' => $items
    ];

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If no order items found, return an error
    http_response_code(404); // Not Found
    echo json_encode(['error' => 'No details found for this order']);
}
?>
