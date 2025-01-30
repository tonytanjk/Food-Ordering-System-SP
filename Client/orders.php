<?php
include $_SERVER['DOCUMENT_ROOT'] . '/projectCSAD/Scripts/common.php';
include $_SERVER['DOCUMENT_ROOT'] . '/projectCSAD/Scripts/Account.php';
echo $account, $main_head;

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];

// Check if the cancel button was clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order_id'])) {
    $cancel_order_id = $_POST['cancel_order_id'];

    // Fetch the order details including UNIX timestamp for order_date
    $query = "SELECT total_amount, status, UNIX_TIMESTAMP(order_date) AS order_time FROM orders WHERE order_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $cancel_order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if ($order) {
        $order_time = $order['order_time']; // Now a UNIX timestamp
        $current_time = time();

        // Check if the order is eligible for cancellation (within 2 minutes)
        if ($order['status'] === 'Pending' && ($current_time - $order_time) <= 120) { 
            $refund_amount = $order['total_amount'];

            // Begin transaction
            $conn->begin_transaction();
            try {
                // Update the order status to "Cancelled"
                $update_status_query = "UPDATE orders SET status = 'Cancelled' WHERE order_id = ?";
                $stmt = $conn->prepare($update_status_query);
                $stmt->bind_param('i', $cancel_order_id);
                $stmt->execute();

                // Refund the user's balance
                $update_balance_query = "UPDATE users SET account_balance = account_balance + ? WHERE user_id = ?";
                $stmt = $conn->prepare($update_balance_query);
                $stmt->bind_param('di', $refund_amount, $user_id);
                $stmt->execute();

                $conn->commit();
                $success_message = "Order #$cancel_order_id has been successfully cancelled. A refund of $$refund_amount has been applied.";
            } catch (Exception $e) {
                $conn->rollback();
                $error_message = "Failed to cancel the order: " . $e->getMessage();
            }
        } else {
            $error_message = "The order can no longer be canceled. Cancellation is only allowed within the first 2 minutes.";
        }
    } else {
        $error_message = "Order not found or you are not authorized to cancel it.";
    }
}

// Fetch current and cancelled orders for the logged-in user
$query = "
    SELECT o.order_id, o.total_amount, o.payment_method, UNIX_TIMESTAMP(o.order_date) AS order_time, o.status, 
           oi.food_item_id, oi.quantity, oi.price, fi.food_name
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN food_items fi ON oi.food_item_id = fi.food_item_id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Scripts/FC1_6_CSS.css">
    <title>Current and Cancelled Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }
        .message {
            text-align: center;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
        }
        .success {
            color: green;
            background-color: #e8f5e9;
        }
        .error {
            color: red;
            background-color: #fbe9e7;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
        .cancel-btn {
            display: inline-block;
            padding: 5px 10px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
        }
        .cancel-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Orders</h2>

    <!-- Display messages -->
    <?php if (isset($success_message)): ?>
        <div class="message success"><?= htmlspecialchars($success_message) ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="message error"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Food Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Amount</th>
                <th>Payment Method</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($order['order_id']) ?></td>
                    <td><?= htmlspecialchars($order['food_name']) ?></td>
                    <td><?= htmlspecialchars($order['quantity']) ?></td>
                    <td>$<?= number_format($order['price'], 2) ?></td>
                    <td>$<?= number_format($order['total_amount'], 2) ?></td>
                    <td><?= htmlspecialchars($order['payment_method']) ?></td>
                    <td><?= date("Y-m-d H:i:s", $order['order_time']) ?></td>
                    <td><?= htmlspecialchars($order['status']) ?></td>
                    <td>
                        <?php if ($order['status'] === 'Pending' && (time() - $order['order_time']) <= 120): ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="cancel_order_id" value="<?= $order['order_id'] ?>">
                                <button type="submit" class="cancel-btn">Cancel</button>
                            </form>
                        <?php elseif($order['status'] === 'Cancelled'): ?>
                            <span style="color: gray;">Cancelled</span>
                        <?php else: ?>
                            <span style="color: red;">Not Allowed</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
