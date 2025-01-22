<?php/*
// Start the session to access user information
session_start();

// Assume a PDO connection to the database
$pdo = new PDO("mysql:host=localhost;dbname=food_court", 'root', '');

// Fetch orders from the database for the logged-in user
$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session

$query = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_date DESC";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $user_id]);

$orders = $stmt->fetchAll();
*/?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        header nav a:hover {
            text-decoration: underline;
        }

        .container {
            width: 80%;
            margin: 20px auto;
        }

        .order-header {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .order-header h2 {
            margin: 0;
            font-size: 28px;
            color: #333;
        }

        .order {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .order .order-details {
            margin-bottom: 10px;
        }

        .order .order-details p {
            margin: 5px 0;
        }

        .order .button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .order .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<header>
    <h1>Food Ordering System @ SP</h1>
    <nav>
        <a href="../Home.php">Home</a>
        <a href="../FoodCourts/FC.php">Food Courts</a>
        <a href="../Most_Order.php">Most Ordered</a>
        <a href="#">About Us</a>
        <a href="#">Contact</a>
        <a href="../UserProcess/login.php">Logout</a>
    </nav>
</header>

<div class="container">
    <div class="order-header">
        <h2>Your Order History</h2>
    </div>

    <?php if (count($orders) > 0): ?>
        <?php foreach ($orders as $order): ?>
            <div class="order">
                <div class="order-details">
                    <p><strong>Order ID:</strong> <?php echo $order['tracking_id']; ?></p>
                    <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
                    <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
                    <p><strong>Total Cost:</strong> $<?php echo number_format($order['total_cost'], 2); ?></p>
                </div>

                <div class="order-items">
                    <h3>Items Ordered:</h3>
                    <?php
                    $order_id = $order['id'];
                    $items_query = "SELECT * FROM order_items WHERE order_id = :order_id";
                    $items_stmt = $pdo->prepare($items_query);
                    $items_stmt->execute(['order_id' => $order_id]);
                    $items = $items_stmt->fetchAll();
                    ?>
                    <ul>
                        <?php foreach ($items as $item): ?>
                            <li><?php echo $item['food_name']; ?> (x<?php echo $item['quantity']; ?>)</li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <a href="#" class="button">View Order Details</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>You have no past orders yet.</p>
    <?php endif; ?>
</div>

</body>
</html>
