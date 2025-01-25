<?php
// Include database connection and common functions
include '../scripts/common.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit;
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch current orders for the logged-in user that are not completed
$query = "
    SELECT o.order_id, o.total_amount, o.payment_method, o.order_date, oi.food_item_id, oi.quantity, oi.price, fi.food_name
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN food_items fi ON oi.food_item_id = fi.food_item_id
    WHERE o.status = 'Pending' AND o.user_id = ?
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
    <title>Current Orders</title>
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
    </style>
</head>
<body>
    <header>
        <h1>Current Orders</h1>
        <nav>
            <a href="../Home.php">Home</a>
            <a href="../Most_Order.php">Most Ordered</a>
            <a href="About.html">About Us</a>
            <a href="Contact.html">Contact</a>
            <a href="login.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h2>Current Orders</h2>
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
                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>