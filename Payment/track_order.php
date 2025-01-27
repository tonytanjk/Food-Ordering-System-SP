<?php
include '../Scripts/common.php';

// Check if the tracking ID is set
if (!isset($_SESSION['tracking_id'])) {
    echo "No tracking ID found.";
    exit;
}

// Get the tracking ID from the session
$tracking_id = $_SESSION['tracking_id'];

// Fetch the order details based on the tracking ID
$stmt = $pdo->prepare("SELECT * FROM orders WHERE tracking_id = :tracking_id");
$stmt->execute(['tracking_id' => $tracking_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "Order not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            max-width: 600px;
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

        .order-details {
            margin-bottom: 20px;
        }

        .order-details span {
            display: block;
            margin-bottom: 10px;
        }

        .order-details span strong {
            color: #007bff;
        }
                button {
            display: block;
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-home {
            margin-top: 20px;
            text-align: center;
        }

        .back-home a {
            text-decoration: none;
            color: #fff;
            background-color: #28a745;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .back-home a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Tracking</h1>
        <div class="order-details">
            <span><strong>Tracking ID:</strong> <?php echo htmlspecialchars($order['tracking_id']); ?></span>
            <span><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></span>
            <span><strong>Total Amount:</strong> $<?php echo number_format($order['total_amount'], 2); ?></span>
            <span><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></span>
            <span><strong>Order Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?></span>
        </div>
       <!-- Back to Home Button -->
        <div class="back-home">
            <a href="../Home.php">Back to Home</a>
        </div>
    </div>
</body>
</html>