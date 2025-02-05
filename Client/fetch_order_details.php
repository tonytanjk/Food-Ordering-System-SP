<?php
// Include common.php for database connection and common functions
include '../scripts/common.php';

// Get the order ID from the query string
$order_id = $_GET['order_id'];

// Fetch order items and cancellation reason (if any)
$query = "
    SELECT oi.quantity, fi.food_name, oi.price, ord.status, ord.reason
    FROM order_items oi
    JOIN food_items fi ON oi.food_item_id = fi.food_item_id
    JOIN orders ord ON oi.order_id = ord.order_id
    WHERE oi.order_id = ? AND ord.order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $order_id, $order_id);
$stmt->execute();
$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);

// Check if any order items are found
if ($result->num_rows > 0) {
    // Fetch the cancellation reason and include it in the response
    $order_status = $items[0]['status'];  // Assuming all items in the same order will have the same status
    $reason = $order_status === 'Cancelled' ? $items[0]['reason'] : null;

    // Return the order items along with the status and cancellation reason (if any)
    $response = [
        'status' => $order_status,
        'reason' => $reason,
        'items' => $items
    ];

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If no order items found, return an error
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No details found for this order']);
}
?>
