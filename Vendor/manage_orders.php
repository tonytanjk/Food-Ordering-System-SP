<?php
include '../scripts/common.php'; // Include common.php for database connection and common functions
include 'VendorCommon.php';

// Fetch stall_id and food_court_id for the logged-in user
$user_id = $_SESSION['user_id'];
$query = "SELECT stall_id, food_court_id FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stall_id = $user['stall_id'] ?? 0;
$food_court_id = $user['food_court_id'] ?? 0;

// Fetch open orders for this stall and food court
$query = "
    SELECT o.order_id, o.tracking_id, o.total_amount, o.payment_method, o.order_date, u.username, oi.food_item_id, fi.food_court_id, fi.stall_id
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN food_items fi ON oi.food_item_id = fi.food_item_id
    WHERE o.status = 'Pending' 
    AND fi.food_court_id = ? AND fi.stall_id = ?
    ORDER BY o.order_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $food_court_id, $stall_id); // Bind the vendor's food_court_id and stall_id
$stmt->execute();
$result = $stmt->get_result();

// Check if the query returned any results
if ($result->num_rows > 0) {
    $orders = $result->fetch_all(MYSQLI_ASSOC); // Fetch all results as an associative array
} else {
    $orders = null; // Set to null if no orders are found
}

// Handle order status updates
if (isset($_POST['close_order'])) {
    $order_id = $_POST['order_id'];
    $stmt = $conn->prepare("UPDATE orders SET status = 'Completed' WHERE order_id = ?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();

    // Redirect to refresh the list of orders
    header("Location: manage_orders.php");
    exit();
}

if (isset($_POST['cancel_order'])) {
    $order_id = $_POST['order_id'];
    $reason = $_POST['reason']; // Get cancellation reason from POST data

    // Check if reason is not empty
    if (!empty($reason)) {
        // Update order status to 'Cancelled' and save reason
        $stmt = $conn->prepare("UPDATE orders SET status = 'Cancelled', reason = ? WHERE order_id = ?");
        $stmt->bind_param('si', $reason, $order_id);
        $stmt->execute();

        // Redirect to refresh the list of orders
        header("Location: manage_orders.php");
        exit();
    } else {
        echo "<script>alert('Please provide a reason for cancellation.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Scripts/FC1_6_CSS.css">
    <title>Vendor Orders</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .action-button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .close-button {
            background-color: #28a745;
            color: white;
        }

        .close-button:hover {
            background-color: #218838;
        }

        .cancel-button {
            background-color: #dc3545;
            color: white;
        }

        .cancel-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <header>
        <h1 style="color: white">Manage Orders</h1>
        <?php echo $navi; // Display the navigation bar ?>
    </header>
    <div class="container">
        <h1>Open Orders</h1>
        <?php if ($orders === null): ?>
            <p>No orders yet.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Tracking ID</th>
                        <th>Username</th>
                        <th>Total Amount</th>
                        <th>Payment Method</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['order_id']) ?></td>
                            <td><?= htmlspecialchars($order['tracking_id']) ?></td>
                            <td><?= htmlspecialchars($order['username']) ?></td>
                            <td>$<?= number_format($order['total_amount'], 2) ?></td>
                            <td><?= htmlspecialchars($order['payment_method']) ?></td>
                            <td><?= htmlspecialchars($order['order_date']) ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">
                                    <button type="submit" name="close_order" class="action-button close-button">Close Order</button>
                                    <button type="button" class="action-button cancel-button" onclick="confirmCancel(<?= htmlspecialchars($order['order_id']) ?>)">Cancel Order</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script>
        function confirmCancel(orderId) {
            const reason = prompt("Please provide a reason for canceling this order:");
            if (reason !== null && reason.trim() !== "") {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'manage_orders.php';
                
                const orderIdInput = document.createElement('input');
                orderIdInput.type = 'hidden';
                orderIdInput.name = 'order_id';
                orderIdInput.value = orderId;
                form.appendChild(orderIdInput);

                const reasonInput = document.createElement('input');
                reasonInput.type = 'hidden';
                reasonInput.name = 'reason';
                reasonInput.value = reason;
                form.appendChild(reasonInput);

                const cancelOrderInput = document.createElement('input');
                cancelOrderInput.type = 'hidden';
                cancelOrderInput.name = 'cancel_order';
                form.appendChild(cancelOrderInput);

                document.body.appendChild(form);
                form.submit();
            } else {
                alert("Reason is required to cancel the order.");
            }
        }
    </script>
</body>
</html>
