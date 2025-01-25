<?php
session_start();
include '../scripts/common.php'; // Include common.php for database connection and common functions

// Check if the vendor is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: ../UserProcess/login.php');
    exit;
}

// Fetch open orders
$query = "
    SELECT o.order_id, o.tracking_id, o.total_amount, o.payment_method, o.order_date, u.username
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    WHERE o.status = 'Pending'
    ORDER BY o.order_date DESC";
$stmt = $conn->prepare($query); // Use $conn from common.php
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); // Fetch all results as an associative array

// Handle order closing
if (isset($_POST['close_order'])) {
    $order_id = $_POST['order_id'];
    $stmt = $conn->prepare("UPDATE orders SET status = 'Completed' WHERE order_id = ?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();

    // Redirect to the same page to refresh the list of orders
    header("Location: vendor_orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .close-button {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .close-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Open Orders</h1>
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
                                <button type="submit" name="close_order" class="close-button">Close Order</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>