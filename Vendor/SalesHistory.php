<?php
session_start();
include '../scripts/common.php'; // Include common.php for database connection and common functions

// Fetch sales history for the vendor using stall_id (already managed in common.php)
$query = "
    SELECT o.order_id, oi.quantity, oi.price, fi.food_name, o.total_amount, o.payment_method, o.order_date, o.status
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN food_items fi ON oi.food_item_id = fi.food_item_id
    WHERE o.status = 'Completed'
    ORDER BY o.order_date DESC";
$stmt = $conn->prepare($query); // Use $conn from common.php
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); // Fetch all results as an associative array
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Scripts/FC1_6_CSS.css">
    <title>Sales History</title>
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

        .completed {
            color: green;
        }

        .cancelled {
            color: red;
        }

        .pending {
            color: orange;
        }
    </style>
</head>
<body>
    <header>
        <h1 style="color: white">Sales History</h1>
        <nav>
            <a href="vendor_home.php">Home</a>
            <a href="SalesMetrics.php">Sales Metrics</a>
            <a href="SalesHistory.php">Sales History</a>
            <a href="../Client/login.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h1>Your Sales History</h1>
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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['order_id']) ?></td>
                        <td><?= htmlspecialchars($order['food_name']) ?></td>
                        <td>$<?= number_format($order['total_amount'], 2) ?></td>
                        <td><?= htmlspecialchars($order['payment_method']) ?></td>
                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                        <td>
                            <?php
                            if ($order['status'] === 'Completed') {
                                echo "<span class='completed'>" . htmlspecialchars($order['status']) . "</span>";
                            } elseif ($order['status'] === 'Cancelled') {
                                echo "<span class='cancelled'>" . htmlspecialchars($order['status']) . "</span>";
                            } else {
                                echo "<span class='pending'>" . htmlspecialchars($order['status']) . "</span>";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
